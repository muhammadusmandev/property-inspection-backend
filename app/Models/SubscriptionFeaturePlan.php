<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeaturePlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'plan_id',
        'subscription_feature_id',
        'value'
    ];

    /**
     * The plan belong to this record.
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    /**
     * The feature belong to this record.
     */
    public function feature()
    {
        return $this->belongsTo(SubscriptionFeature::class, 'subscription_feature_id');
    }
}
