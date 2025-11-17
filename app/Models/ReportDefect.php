<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefect extends Model
{
    protected $fillable = [
        'report_inspection_area_id',
        'inspection_area_item_id',
        'defect_type',
        'remediation',
        'priority',
        'comments'
    ];

    public function area()
    {
        return $this->belongsTo(ReportInspectionArea::class);
    }

    public function item()
    {
        return $this->belongsTo(InspectionAreaItem::class, 'inspection_area_item_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
