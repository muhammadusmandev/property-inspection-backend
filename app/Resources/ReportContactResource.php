<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'report_id'      => $this->report_id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'contact_type'   => $this->contact_type,
            'can_sign'       => $this->can_sign,
            'signature_path' => $this->signature_path,
            'signature_url'  => $this->signature_url,
            'signed_at'      => $this->signed_at,
            'report'         => $this->report,
        ];
    }
}
