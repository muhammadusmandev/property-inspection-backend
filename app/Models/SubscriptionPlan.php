<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'monthly_price',
        'annual_price',
        'currency',
        'stripe_monthly_price_id',
        'stripe_annual_price_id',
        'description',
        'is_active',
    ];

    /**
     * Get the features associated with the plan.
     */
    public function features()
    {
        return $this->belongsToMany(SubscriptionFeature::class, 'subscription_feature_plans', 'plan_id', 'subscription_feature_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
