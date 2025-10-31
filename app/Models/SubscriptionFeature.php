<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The Subscription that belong to the feature.
     */
    public function plans()
    {
        return $this->belongsToMany(Subscription::class)
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
