<?php

namespace App\Resources;

use Illuminate\Http\Request;
use App\Resources\SubscriptionPlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowBillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
            'plans' => SubscriptionPlanResource::collection($this)
        ];
    }
}
