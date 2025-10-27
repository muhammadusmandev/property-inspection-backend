<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'user_id',
        'associated_property_id',
        'name',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'postal_code',
    ];


     public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function properties()
    {
        return $this->hasOne(Property::class, 'id', 'associated_property_id');
    }
}
