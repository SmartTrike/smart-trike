<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInformation extends Model
{
    use HasFactory;

    protected $table = 'driver_information';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'contact_number',
        'address',
        'birthdate',
        'license_number',
        'license_expiry_date',
        'operator_name',
        'operator_contact',
        'operator_address',
        'mtop_number',
        'tricycle_body_number',
        'plate_number',
        'engine_number',
        'chassis_number',
        'color',
        'model',
        'year_acquired',
        'status',
         ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
