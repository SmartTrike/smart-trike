<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;
    
    protected $table = 'rides';

    protected $fillable = [
        'driver_id',
        'dispatcher_id',
        'passenger_count',
        'dispatch_at',
        'returned_at',
        'status',
        'remarks',
    ];

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
