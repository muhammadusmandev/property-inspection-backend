<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefect extends Model
{
    protected $fillable = [
        'report_section_id',
        'category',
        'description'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
