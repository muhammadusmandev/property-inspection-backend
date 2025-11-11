<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionChecklist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'label', 
        'type'
    ];

    /**
     * Report Inspection Checklist Items from Inspection Checklist.
     */
    public function reportItems()
    {
        return $this->hasMany(ReportChecklistItem::class);
    }
}
