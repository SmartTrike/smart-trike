<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FareSetting extends Model
{
    protected $table = 'fare_settings';

    protected $fillable = [
        'label',
        'trip_fare',
        'terminal_fare',
        'hire_fare',
        'is_current',
    ];

  protected static function booted()
    {
        static::saving(function ($fare) {
            // If the fare we are saving is set to active
            if ($fare->is_current) {
                // Set all other fares to inactive
                static::where('id', '!=', $fare->id)->update(['is_current' => false]);
            }
        });
    }
}
