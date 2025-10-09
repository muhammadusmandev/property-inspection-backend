<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    protected array $token;

    public function __construct($resource, array $tokenData)
    {
        parent::__construct($resource);
        $this->tokenData = $tokenData;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => [
                'text' => $this->tokenData['token'],
                'type' => 'Bearer',
                'expires_at' => $this->tokenData['expires_at'],
            ],
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'roles' => ['realtor'],     // Todo: Need to show user roles if multiple
                'avatar_url' => $this->avatar_url ?? null,
            ],
        ];
    }
}
