<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DispatcherInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DispatcherInformationSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 sample dispatchers
        for ($i = 1; $i <= 3; $i++) {

            // Create user account
            $accountId = 'DSP-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => "Dispatcher $i",
                'role' => 'dispatcher',
                'account_id' => $accountId,
                'password' => Hash::make($accountId), // initial password = account_id
            ]);

            // Create dispatcher information
            DispatcherInformation::create([
                'user_id' => $user->id,
              
                'first_name' => "DispatcherFirst$i",
                'middle_name' => "M",
                'last_name' => "DispatcherLast$i",
                'suffix' => null,
                'contact_number' => '0922123456' . $i,
                'address' => "Barangay Address $i",
                'shift' => ['morning', 'afternoon', 'evening'][($i - 1) % 3],
                'assigned_terminal' => "Terminal $i",
                'date_started' => now()->subYears(2)->format('Y-m-d'),
                'status' => 'active',
            ]);
        }
    }
}
