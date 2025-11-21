<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionAreaDefectResource extends JsonResource
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
            'report_inspection_area_id' => $this->report_inspection_area_id,
            'inspection_area_item_id' => $this->inspection_area_item_id,
            'area_item_name' => $this->item?->name,
            'defect_type' => $this->defect_type,
            'remediation' => $this->remediation,
            'priority' => $this->priority,
            'comments' => $this->comments,
            'images' => MediaResource::collection($this->media),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
