<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DriverInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DriverInformationSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 sample drivers
        for ($i = 1; $i <= 5; $i++) {

            // Create user account
            $accountId = 'DRV' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => "Driver $i",
                'role' => 'driver',
                'account_id' => $accountId,
                'password' => Hash::make($accountId), // initial password = account_id
            ]);

            // Create driver information
            DriverInformation::create([
                'user_id' => $user->id,
                'first_name' => "DriverFirst$i",
                'middle_name' => "M",
                'last_name' => "DriverLast$i",
                'suffix' => null,
                'contact_number' => '0912345678' . $i,
                'address' => "Barangay Address $i",
                'birthdate' => now()->subYears(25 + $i)->format('Y-m-d'),
                'license_number' => 'LIC' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'license_expiry_date' => now()->addYears(5)->format('Y-m-d'),
                'operator_name' => "Operator $i",
                'operator_contact' => '0911122233' . $i,
                'operator_address' => "Operator Address $i",
                'mtop_number' => 'MTOP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tricycle_body_number' => 'BODY' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'plate_number' => 'PLT' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'engine_number' => 'ENG' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'chassis_number' => 'CHS' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'color' => 'Red',
                'model' => 'Honda TMX',
                'year_acquired' => now()->year - $i,
                'status' => 'active',
                
            ]);
        }
    }
}
