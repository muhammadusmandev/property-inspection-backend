<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Temlate, TemplateItem};

class TemplateInspectionArea extends Model
{
    protected $table = 'template_inspection_areas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'template_id', 
        'inspection_area_id'
    ];

    /**
     * Record belongs to template.
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    
}
