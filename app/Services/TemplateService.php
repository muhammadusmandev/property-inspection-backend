<?php

namespace App\Services;

use App\Models\Template;
use App\Repositories\Contracts\TemplateRepository;
use App\Services\Contracts\TemplateService as TemplateServiceContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class TemplateService implements TemplateServiceContract
{
    protected TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function listTemplates():AnonymousResourceCollection
    {
        return $this->templateRepository->getAllForUser(Auth::id());
    }

    public function createTemplate(array $data): Template
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = Auth::id();
            $template = $this->templateRepository->create($data);

            foreach ($data['sections'] ?? [] as $sectionData) {
                $section = $template->sections()->create([
                    'name' => $sectionData['name'],
                    'order' => $sectionData['order'] ?? 0,
                ]);

                foreach ($sectionData['items'] ?? [] as $itemData) {
                    $section->items()->create([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'] ?? null,
                    ]);
                }
            }

            return $template->load('sections.items');
        });
    }

    public function showTemplate(int $id): Template
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }
        return $template;
    }

    public function updateTemplate(int $id, array $data): Template
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }

        if ($template->created_by !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return DB::transaction(function () use ($template, $data) {
            $this->templateRepository->update($template, $data);

            $template->sections()->delete();

            foreach ($data['sections'] ?? [] as $sectionData) {
                $section = $template->sections()->create([
                    'name' => $sectionData['name'],
                    'order' => $sectionData['order'] ?? 0,
                ]);

                foreach ($sectionData['items'] ?? [] as $itemData) {
                    $section->items()->create([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'] ?? null,
                    ]);
                }
            }

            return $template->load('sections.items');
        });
    }

    public function deleteTemplate(int $id): void
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }

        if ($template->created_by !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->templateRepository->delete($template);
    }
}
