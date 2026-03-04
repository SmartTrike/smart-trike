<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
        'reported_by',
        'driver_id',
        'reviewed_by',
        'violation_id',
        'event_date',
        'admin_remarks',
        'evidence',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'evidence' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Driver being reported
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Person who reported
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // Admin who reviewed
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Generated violation
    public function violation()
    {
        return $this->belongsTo(DriverViolation::class, 'violation_id');
    }
}
