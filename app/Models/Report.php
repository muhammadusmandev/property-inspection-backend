<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    protected $fillable = [
        'property_id',
        'template_id',
        'user_id',
        'title',
        'type',
        'status',
        'notes',
        'report_date'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id','id');
    }

     public function template()
    {
        return $this->belongsTo(Template::class,'template_id','id');
    }

    public function areas()
    {
        return $this->hasMany(ReportInspectionArea::class);
    }
}
