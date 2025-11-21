<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The Subscription plans that belong to the feature.
     */
    public function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_feature_plans', 'subscription_feature_id', 'plan_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
