<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportAreaResource extends JsonResource
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
            'description' => $this->description,
            'condition' => $this->condition,
            'cleanliness' => $this->cleanliness,
            'media' => MediaResource::collection($this->media),
            'items' => ReportAreaItemResource::collection($this->whenLoaded('items')) ?? [],
        ];
    }
}
