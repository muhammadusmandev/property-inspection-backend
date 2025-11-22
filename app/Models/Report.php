<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\InspectionChecklist;

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
        'report_date',
        'locked_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) \Str::uuid();
            }
        });
    }

    /**
     * property belongs to a user (realtor/inspector).
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id','id');
    }

     public function template()
    {
        return $this->belongsTo(Template::class,'template_id','id');
    }

    public function areas()
    {
        return $this->hasMany(ReportInspectionArea::class);
    }

    public function checklistItems()
    {
        return $this->hasMany(ReportChecklistItem::class);
    }

    // Checklist items with statuses
    public function checklistItemsWithStatus()
    {
        $checklists = InspectionChecklist::all();

        // Map to include checked status for this report
        return $checklists->map(function ($item) {
            $reportItem = $this->checklistItems()
                ->where('inspection_checklist_id', $item->id)
                ->first();

            return [
                'id' => $item->id,
                'label' => $item->label,
                'type' => $item->type,
                'checked' => $reportItem ? $reportItem->checked : false,
            ];
        });
    }
}
