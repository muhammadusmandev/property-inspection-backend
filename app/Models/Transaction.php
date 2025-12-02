<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'plan_id',
        'amount',
        'currency',
        'gateway',  
        'gateway_transaction_id',
        'type',
        'status',
        'paid_at',
        'refunded_at',
        'metadata'
    ];
}
