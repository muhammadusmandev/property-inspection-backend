<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Report,
    ReportSectionItem,
    ReportSectionDefect,
    Media
};

class ReportSection extends Model
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
        return $this->hasMany(ReportSectionItem::class);
    }

    public function defects()
    {
        return $this->hasMany(ReportSectionDefect::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
