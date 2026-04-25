<?php
// database/seeders/SchoolSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schools')->insert([
            [
                'name' => 'Demo Central School',
                'code' => 'DCS001',
                'address' => '123 Education Road, Lagos, Nigeria',
                'phone' => '+2348012345678',
                'email' => 'info@democentralschool.com',
                'logo' => 'schools/logo.png',
                'website' => 'https://democentralschool.com',
                'motto' => 'Excellence in Education',
                'established_year' => 2010,
                'slogan' => 'Building Future Leaders',
                'currency' => '₦',
                'timezone' => 'Africa/Lagos',
                'academic_term' => 'term',
                'status' => 'active',
                'settings' => json_encode([
                    'theme' => 'light',
                    'language' => 'en',
                    'date_format' => 'Y-m-d',
                    'time_format' => 'H:i'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}