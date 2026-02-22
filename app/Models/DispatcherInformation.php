<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatcherInformation extends Model
{
    use HasFactory;

    protected $table = 'dispatcher_information';

    protected $fillable = [
        'user_id',
       'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'contact_number',
        'address',
        'shift',
        'assigned_terminal',
        'date_started',
        'status',
    ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
