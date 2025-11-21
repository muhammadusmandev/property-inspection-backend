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
    protected $fillable = ['report_inspection_area_id', 'name', 'description', 'condition','cleanliness','order'];
    public function area()
    {
        return $this->belongsTo(ReportInspectionArea::class);
    }


    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
