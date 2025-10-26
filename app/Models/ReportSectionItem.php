<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSectionItem extends Model
{
    protected $fillable = ['report_section_id', 'name', 'description', 'condition','cleanliness','order'];
    public function section()
    {
        return $this->belongsTo(ReportSection::class);
    }

    public function defects()
    {
        return $this->hasMany(ReportSectionDefect::class, 'report_section_item_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
