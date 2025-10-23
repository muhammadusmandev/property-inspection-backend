<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Temlate, TemplateItem};

class TemplateSection extends Model
{
    protected $fillable = ['template_id', 'name', 'order'];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function items()
    {
        return $this->hasMany(TemplateItem::class);
    }
}
