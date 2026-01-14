<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\InspectionAreaResource;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_default' => (bool) $this->is_default,
            'inspector_id' => $this->inspector_id,
            'areas' => InspectionAreaResource::collection($this->whenLoaded('areas')),
        ];
    }
}
