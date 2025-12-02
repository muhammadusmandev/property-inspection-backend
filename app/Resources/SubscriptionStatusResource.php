<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'is_subscribed' => $request->user()->subscribed('default'),
            'active' => $this?->active() ?? false,
            'on_trial' => $this?->onTrial() ?? false,
            'ended' => $this?->ended() ?? false,
            'cancelled' => $this->ends_at && $this->ends_at->isPast(),
            'trial_start' => $this?->trial_ends_at?->subDays($subscription->trial_days ?? 0)->toISOString(),
            'trial_end' => $this?->trial_ends_at?->toISOString(),
        ];
    }
}
