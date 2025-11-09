<?php

namespace App\Resources;

use Illuminate\Http\Request;
use App\Resources\InspectionAreaItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportInspectionAreaResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'condition'   => $this->condition,
            'cleanliness'   => $this->cleanliness,
            'description'   =>  $this->description,
            'items' => $this->whenLoaded('items'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
