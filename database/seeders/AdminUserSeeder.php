<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'yamansharmarakta@gmail.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Yaman Sharma',
                'email' => 'yamansharmarakta@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
            ]);
            
            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}