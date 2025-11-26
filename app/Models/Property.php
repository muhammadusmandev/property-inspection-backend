<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'branch_id',
        'name',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'postal_code',
        'type',
        'active',
        'notes',
        'description',
        'reference'
    ];

    /**
     * property belongs to a user (inspector).
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * property may belong to a branch.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * property can have many rooms.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

     /**
     * property may belong to a branch.
     */
    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }
}
