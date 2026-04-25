<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Users
        DB::table('users')->insert([
            [
                'school_id' => 1,
                'username' => 'superadmin',
                'email' => 'superadmin@school.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone' => '+2348012345678',
                'address' => 'Head Office, Lagos',
                'status' => 'active',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 1,
                'username' => 'admin',
                'email' => 'admin@school.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone' => '+2348012345679',
                'address' => 'Admin Office',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Teacher Users
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'school_id' => 1,
                'username' => "teacher{$i}",
                'email' => "teacher{$i}@school.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone' => "+23480234567{$i}",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Student Users
        for ($i = 1; $i <= 50; $i++) {
            DB::table('users')->insert([
                'school_id' => 1,
                'username' => "student{$i}",
                'email' => "student{$i}@school.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone' => "+23480345678{$i}",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Parent Users
        for ($i = 1; $i <= 30; $i++) {
            DB::table('users')->insert([
                'school_id' => 1,
                'username' => "parent{$i}",
                'email' => "parent{$i}@family.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone' => "+23480456789{$i}",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}