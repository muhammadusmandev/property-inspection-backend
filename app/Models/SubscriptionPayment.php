<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    protected $fillable = [
        'subscription_id',
        'user_id',
        'plan_id',
        'amount',
        'currency',
        'gateway',
        'gateway_payment_id', 
        'status',
        'pending',
        'paid_at',
    ];
}
