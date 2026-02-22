<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverQueue extends Model
{
    use HasFactory;

    protected $table = 'driver_queues';


    protected $fillable = [
        'driver_id',
        'status',
    ];

    // Relationship with the Driver/User
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}