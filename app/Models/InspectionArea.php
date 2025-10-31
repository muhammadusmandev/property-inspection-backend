<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionArea extends Model
{
    protected $table = 'inspection_areas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'realtor_id',
        'is_default',
    ];

    /**
     * Area have many Items.
     */
    public function items()
    {
        return $this->belongsToMany(InspectionAreaItem::class, 'inspection_area_item', 'area_id', 'item_id')
                    ->withTimestamps();
    }

    /**
     * Item belongs to realtor.
     */

    public function realtor()
    {
        return $this->belongsTo(User::class, 'realtor_id');
    }
}
