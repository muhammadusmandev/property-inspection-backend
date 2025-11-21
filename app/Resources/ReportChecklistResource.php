<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportChecklistResource extends JsonResource
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
            'report_id' => $this->report_id,
            'checked' => $this->checked,
            'item' => [
                'id' => $this->inspection_checklist_id,
                'label' => $this->checklistItem->label,
                'type' => $this->checklistItem->description,
            ],
        ];
    }
}
