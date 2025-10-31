<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeaturePlan extends Model
{
     protected $fillable = [
        'plan_id',
        'subscription_feature_id',
        'value'
    ];
}
