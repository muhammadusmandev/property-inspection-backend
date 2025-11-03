<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\InspectionAreaResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'property_id' => $this->property_id,
            'template_id' => $this->template_id,
            'status' => $this->status,
            'type' => $this->type,
            'report_date' => $this->report_date,
            'property' => $this->property,
            'template' => $this->template,
            'areas' => ReportAreaResource::collection($this->whenLoaded('areas')) ?? [],

        ];
    }
}
