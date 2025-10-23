<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateSectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'items' => TemplateItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
