<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
