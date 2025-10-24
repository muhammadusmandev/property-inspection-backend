<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_public' => $this->is_public,
            'created_by' => $this->created_by,
            'sections' => TemplateSectionResource::collection($this->whenLoaded('sections')),
        ];
    }
}
