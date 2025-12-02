<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportChecklistItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_id', 
        'inspection_checklist_id', 
        'checked'
    ];

    /**
     * Report Inspection Checklist Item has Inspection Checklist.
     */
    public function checklistItem()
    {
        return $this->belongsTo(InspectionChecklist::class, 'inspection_checklist_id');
    }

    /**
     * Report Inspection Checklist Item belong to report.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
