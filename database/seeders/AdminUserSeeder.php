<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'email' => 'admin@example.com', 
                'username' => 'Admin',      // fixed or auto-generated
                'password' => Hash::make('123456'), // initial password same as account_id
                'role' => 'admin',
            ]);
        }
    }
}
