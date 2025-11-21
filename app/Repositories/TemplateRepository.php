<?php

namespace App\Repositories;

use App\Models\Template;
use App\Resources\TemplateResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TemplateRepository implements \App\Repositories\Contracts\TemplateRepository
{
    public function getAllForUser(int $userId): AnonymousResourceCollection
    {
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');

        $query = Template::with('areas')
            ->where('realtor_id', $userId)
            ->orWhere('is_default', true)
            ->orderBy('is_default', 'ASC')
            ->orderBy('created_at', 'DESC');
        
        if ($columnName && $columnQuery) {
            if (str_contains($columnName, '.')) {      // search query on relation
                [$relation, $column] = explode('.', $columnName);

                $query->whereHas($relation, function ($q) use ($column, $columnQuery) {
                    $q->where($column, 'LIKE', "%{$columnQuery}%");
                });
            } else {
                $query->where($columnName, 'LIKE', "%{$columnQuery}%");
            }
        }

        // Todo: make trait/helper for getting boolean from request safely
        $paginate = filter_var(
            is_string($v = request()->input('paginate', true)) ? trim($v, "\"'") : $v,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? true;

        if (!$paginate) {
            $templates = $query->get();
        } else{
            $templates = $query->paginate(request()->input('perPage') ?? 10);
        }

        return TemplateResource::collection($templates);
    }

    public function findById(int $id): ?Template
    {
        return Template::with('areas')->where('id', $id)->first();
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
        // detach pivot relationship
        $template->areas()->detach();

        return $template->delete();
    }
}
