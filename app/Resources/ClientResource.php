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
            'inspector_id'   => $this->inspector_id,
            'inspector_name' => $this->inspector?->name,
            'created_at'   => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
