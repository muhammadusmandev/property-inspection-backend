<?php

namespace App\Resources;

use Illuminate\Http\Request;
use App\Resources\InspectionAreaItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionAreaResource extends JsonResource
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
            'realtor_id'   => $this->realtor_id,
            'is_default' => (bool) $this->is_default,
            'items' => InspectionAreaItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
