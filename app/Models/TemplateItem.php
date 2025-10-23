<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TemplateSection;
class TemplateItem extends Model
{
    protected $fillable = ['template_section_id', 'name', 'description'];

    public function section()
    {
        return $this->belongsTo(TemplateSection::class, 'template_section_id');
    }
}
