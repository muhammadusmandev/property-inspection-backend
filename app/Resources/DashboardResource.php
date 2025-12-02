<?php

namespace App\Resources;

use Illuminate\Http\Request;
use App\Models\{ Report, Property, User, Branch };
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'generated_reports' => Report::where('user_id', $this->id)->where('status', 'completed')->count(),
            'total_properties' => Property::where('user_id', $this->id)->count(),
            'total_clients' => User::where('inspector_id', $this->id)->count(),
            'total_branches' => Branch::where('user_id', $this->id)->count()
        ];
    }
}
