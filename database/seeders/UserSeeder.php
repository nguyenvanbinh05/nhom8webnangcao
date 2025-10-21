<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'Admin Account',
                'email' => 'admin@example.com',
                'phone' => '0399999999',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Staff Account 1',
                'email' => 'staff1@example.com',
                'phone' => '0300000001',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'role' => 'staff',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Staff Account 2',
                'email' => 'staff2@example.com',
                'phone' => '0300000002',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'role' => 'staff',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Customer Account 1',
                'email' => 'customer1@example.com',
                'phone' => '0310000001',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'role' => 'customer',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Customer Account 2',
                'email' => 'customer2@example.com',
                'phone' => '0310000002',
                'password' => Hash::make('12345678'),
                'status' => 'inactive',
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            user::create($user);
        }
    }
}
