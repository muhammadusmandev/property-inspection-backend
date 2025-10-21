<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    protected array $token;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

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
            'user_id' => $this->user_id,
            'branch' => $this?->branch,
            'rooms' => $this?->rooms,
            'client' => $this?->client,
            'address' => $this->address,
            'address_2' => $this->address_2 ?? null,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'type' => $this->type,
            'active' => $this->active,
            'notes' => $this?->notes,
            'description' => $this->description,
            'reference' => $this->reference
        ];
    }
}
