<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 
        'description', 
        'is_default', 
        'inspector_id'
    ];

    /**
     * Template have many areas.
     */
    public function areas()
    {
        return $this->belongsToMany(InspectionArea::class, 'template_inspection_areas', 'template_id', 'inspection_area_id');
    }

    /**
     * Template belongs to user/inspector.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
