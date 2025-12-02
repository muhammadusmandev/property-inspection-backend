<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBillingDetail extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_payment_method',
        'name',
        'email',
        'address',
        'address_2',
        'city',
        'state',
        'country_code',
        'postal_code'
    ];

    /**
     * Billing Detail belongs to a user (inspector).
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
