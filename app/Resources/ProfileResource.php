<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'avatar_url' => $this->profile_photo,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'date_of_birth' => $this->date_of_birth,
            'registered_at' => $this->created_at
        ];
    }
}
