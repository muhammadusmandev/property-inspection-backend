<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    ReportInspectionArea,
    ReportDefect,
    Media
};
class ReportInspectionAreaItem extends Model
{
    protected $fillable = ['report_section_id', 'name', 'description', 'condition','cleanliness','order'];
    public function section()
    {
        return $this->belongsTo(ReportInspectionArea::class);
    }

    public function defects()
    {
        return $this->hasMany(ReportDefect::class, 'report_section_item_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
