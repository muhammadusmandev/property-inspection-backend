<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Report,
    ReportInspectionAreaItem,
    ReportDefect,
    Media
};

class ReportInspectionArea extends Model
{
    protected $fillable = [
        'report_id',
        'name',
        'condition',
        'cleanliness',
        'description',
        'order'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function items()
    {
        return $this->hasMany(ReportInspectionAreaItem::class);
    }

    public function defects()
    {
        return $this->hasMany(ReportDefect::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
