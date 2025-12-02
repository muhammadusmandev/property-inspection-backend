<?php

namespace App\Services;

use App\Resources\TemplateResource;
use App\Models\{Template, TemplateInspectionArea};
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
            $data['inspector_id'] = Auth::id();
            $template = $this->templateRepository->create($data);

            foreach ($data['areas'] as $area) {
                $section = TemplateInspectionArea::create([
                    'template_id' => $template->id,
                    'inspection_area_id' => $area,
                ]);
            }

            return $template;
        });
    }

    public function showTemplate(int $id): TemplateResource
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }
        return new TemplateResource($template);
    }

    public function updateTemplate(int $id, array $data): Template
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }

        if ($template->inspector_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return DB::transaction(function () use ($template, $data) {
            $this->templateRepository->update($template, $data);

            $template->areas()->sync($data['areas']);

            return $template;
        });
    }

    public function deleteTemplate(int $id): void
    {
        $template = $this->templateRepository->findById($id);
        if (!$template) {
            throw new \Exception('Template not found.');
        }

        if ($template->inspector_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        /** 
         * Todo: uncomment when reports added
         * $hasReports = $template->whereHas('reports')->exists();
         *  if ($hasReports) {
         *     throw new \Exception("Action forbidden. One or more reports using same template.");
         *  }
         **/

        $this->templateRepository->delete($template);
    }
}
