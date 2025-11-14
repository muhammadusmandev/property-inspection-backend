<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefect extends Model
{
    protected $fillable = [
        'report_inspection_area_id',
        'report_inspection_area_item_id',
        'category',
        'description'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
