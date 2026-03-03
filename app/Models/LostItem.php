<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $table = 'lost_and_found';
    protected $fillable = [
        'item_name', 'description', 'type', 'status', 
        'reported_by', 'updated_by', 'date_found_lost', 
        'location_found_lost', 'remarks', 'image_path'
    ];

    protected $casts = [
        'date_found_lost' => 'datetime',
    ];

    public function reporter() {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'updated_by');
    }
}