<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRegisterResource extends JsonResource
{
    protected string $otp;

    public function __construct($resource, string $otp)
    {
        parent::__construct($resource);
        $this->otp = $otp;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'otp' => $this->otp, // Todo: Show in console log until email OTP implmentation
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'avatar_url' => $this->avatar_url ?? null,
            ],
        ];
    }
}
