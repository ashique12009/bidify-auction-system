<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bidify.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Publisher User
        User::create([
            'name' => 'Publisher User',
            'email' => 'publisher@bidify.com',
            'password' => Hash::make('password'),
            'role' => 'publisher',
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@bidify.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
