<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Report,
    ReportInspectionAreaItem,
    ReportDefect,
    Media
};
use Storage;

class ReportInspectionArea extends Model
{
    protected $fillable = [
        'report_id',
        'name',
        'condition',
        'cleanliness',
        'description',
        'order'
    ];

    protected static function booted()
    {
        static::deleting(function ($area) {
            foreach ($area->media as $media) {
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

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function items()
    {
        return $this->hasMany(ReportInspectionAreaItem::class);
    }

    public function defects()
    {
        return $this->hasMany(ReportDefect::class,'report_inspection_area_id','id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
