<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User,TemplateSection};
class Template extends Model
{
    protected $fillable = ['name', 'description', 'is_public', 'created_by'];

    public function sections()
    {
        return $this->hasMany(TemplateSection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
