<?php

namespace App\Repositories;

use App\Models\Template;
use App\Resources\TemplateResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TemplateRepository implements \App\Repositories\Contracts\TemplateRepository
{
    public function getAllForUser(int $userId): AnonymousResourceCollection
    {
        $templates = Template::with('sections.items')
            ->where(function ($q) use ($userId) {
                $q->where('is_public', true)->orWhere('created_by', $userId);
            })
            ->latest()
            ->paginate(10);

        return TemplateResource::collection($templates);
    }

    public function findById(int $id): ?Template
    {
        return Template::with('sections.items')->find($id);
    }

    public function create(array $data): Template
    {
        return Template::create($data);
    }

    public function update(Template $template, array $data): Template
    {
        $template->update($data);
        return $template;
    }

    public function delete(Template $template): bool
    {
        return $template->delete();
    }
}
