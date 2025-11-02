<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
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
}
