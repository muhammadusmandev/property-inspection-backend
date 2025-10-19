<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
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
        return $this->hasMany(Property::class);
    }
}
