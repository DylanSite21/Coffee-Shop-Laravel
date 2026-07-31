<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'  => 'Admin',
                'email' => 'admin@coffeeshop.test',
                'role'  => 'admin',
            ],
            [
                'name'  => 'Manager',
                'email' => 'manager@coffeeshop.test',
                'role'  => 'manager',
            ],
            [
                'name'  => 'Pelanggan',
                'email' => 'user@coffeeshop.test',
                'role'  => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name'              => $userData['name'],
                    'password'          => 'password', // Otomatis ter-hash oleh cast 'password' => 'hashed' di Model
                    'role'              => $userData['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
