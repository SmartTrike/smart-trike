<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $table = 'rides';

    protected $casts = [
        'dispatch_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    protected $fillable = [
        'driver_id',
        'dispatcher_id',
        'passenger_count',
        'dispatch_at',
        'returned_at',
        'status',
        'remarks',
    ];

    public function markAsCompleted($remarks = null)
    {
        return $this->update([
            'status' => 'completed',
            'returned_at' => now(),
            'remarks' => $remarks ?? $this->remarks,
        ]);
    }

    public function getDurationAttribute()
    {
        if (!$this->returned_at || !$this->dispatch_at) {
            return null;
        }

        return $this->dispatch_at->diffInMinutes($this->returned_at);
    }


    /**
     * Cancel the ride.
     */
    public function markAsCancelled($reason = null)
    {
        return $this->update([
            'status' => 'cancelled',
            'remarks' => $reason ?? $this->remarks,
        ]);
    }

    // Relationships
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function dispatcher()
    {
        return $this->belongsTo(User::class, 'dispatcher_id');
    }
}
