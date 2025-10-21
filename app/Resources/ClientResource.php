<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'gender'       => $this->gender,
            'date_of_birth'=> $this->date_of_birth,
            'bio'          => $this->bio,
            'status'       => (bool) $this->is_active,
            'realtor_id'   => $this->realtor_id,
            'realtor_name' => $this->realtor?->name,
            'created_at'   => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
