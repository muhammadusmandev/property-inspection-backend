<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionAreaItemPivot extends Model
{
    protected $table = 'inspection_area_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'area_id',
        'item_id',
    ];
}
