<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'property_id',
        'template_id',
        'user_id',
        'title',
        'type',
        'status',
        'notes',
    ];
}
