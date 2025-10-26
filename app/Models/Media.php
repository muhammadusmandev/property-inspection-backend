<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'mediable',
        'file_path',
        'original_name',
        'type'
    ];
    public function mediable()
    {
        return $this->morphTo();
    }
}
