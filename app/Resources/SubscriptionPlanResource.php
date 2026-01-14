<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\PlanFeatureResource;

class SubscriptionPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'monthly_price' => $this->monthly_price,
            'annual_price' => $this->annual_price,
            'currency' => $this->currency,
            'stripe_monthly_price_id' => $this->stripe_monthly_price_id,
            'is_active' => $this->is_active,
            'features' => PlanFeatureResource::collection($this->whenLoaded('features'))
        ];
    }
}
