<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Cafe',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Manager
        User::create([
            'name' => 'Manager Cafe',
            'email' => 'manager@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // User biasa 1
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // User biasa 2
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // User biasa 3
        User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->command->info('✅ 5 User berhasil dibuat!');
    }
}