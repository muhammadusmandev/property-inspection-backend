<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportContact extends Model
{
    protected $fillable = [
        'report_id',
        'contact_type',
        'name',
        'email',
        'phone',
        'can_view',
        'can_sign',
        'signature_path',
        'signature_data',
        'signed_at',
        'signed_by_ip',
        'signed_hash',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'can_view' => 'boolean',
        'can_sign' => 'boolean',
        'signed_at' => 'datetime',
    ];

    /**
     * Contact belongs to report
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
