<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionAreaItem extends Model
{
    protected $table = 'inspection_area_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'inspector_id',
        'is_default',
    ];

    /**
     * Item have many Areas.
     */
    public function items()
    {
        return $this->belongsToMany(InspectionArea::class, 'inspection_area_item', 'area_id', 'item_id')
                    ->withTimestamps();
    }

    /**
     * Item belongs to inspector.
     */

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
