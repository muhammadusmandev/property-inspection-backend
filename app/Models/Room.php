<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'order',
    ];

    /**
     * Room belongs to a property.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
