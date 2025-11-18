<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ReportDefect extends Model
{
    protected $fillable = [
        'report_inspection_area_id',
        'inspection_area_item_id',
        'defect_type',
        'remediation',
        'priority',
        'comments'
    ];

    protected $appends = ['item_name'];

    protected static function booted()
    {
        static::deleting(function ($defect) {
            foreach ($defect->media as $media) {
                // delete file
                if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }

                // delete thumbnail if exist
                if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
                    Storage::disk('public')->delete($media->thumbnail_path);
                }

                $media->delete();
            }
        });
    }

    public function area()
    {
        return $this->belongsTo(ReportInspectionArea::class, 'report_inspection_area_id');
    }

    public function item()
    {
        return $this->belongsTo(InspectionAreaItem::class, 'inspection_area_item_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getItemNameAttribute(){
        return $this->item?->name;
    }
}
