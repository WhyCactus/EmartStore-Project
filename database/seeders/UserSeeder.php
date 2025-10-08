<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@emart.com',
                'password' => Hash::make('123456789'),
                'full_name' => 'Admin',
                'phone' => '0123456789',
                'avatar' => '',
                'status' => 'active',
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123456789'),
                'full_name' => 'User',
                'phone' => '0123456789',
                'avatar' => '',
                'status' => 'active',
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'jane doe',
                'email' => 'jane@emart.com',
                'password' => Hash::make('123456789'),
                'full_name' => 'Jane Doe',
                'phone' => '0123456789',
                'avatar' => '',
                'status' => 'active',
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
