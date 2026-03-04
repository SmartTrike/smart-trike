<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'violation',
        'driver_id',
        'filed_by',
        'suspension_days',
        'suspension_start_date',
        'suspension_end_date',
        'remarks',
    ];

    protected $casts = [
        'suspension_start_date' => 'date',
        'suspension_end_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Driver punished
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Admin who filed it
    public function filer()
    {
        return $this->belongsTo(User::class, 'filed_by');
    }

    // Related report
    public function report()
    {
        return $this->hasOne(Report::class, 'violation_id');
    }
}
