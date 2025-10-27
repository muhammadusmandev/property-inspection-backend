<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'address' => $this->address,
            'address_2' => $this->address_2 ?? null,
            'city' => $this->city,
            'state' => $this->state ?? null,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'associated_property_id' => $this->associated_property_id,
            'properties' => $this->properties,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
