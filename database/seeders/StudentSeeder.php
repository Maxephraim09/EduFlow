<?php
// database/seeders/StudentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Mary', 'James', 'Patricia', 'Robert', 'Jennifer'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
        
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            
            DB::table('students')->insert([
                'user_id' => 13 + $i, // After 12 admin/teacher users
                'school_id' => 1,
                'admission_number' => 'ADM' . date('Y') . str_pad($i, 4, '0', STR_PAD_LEFT),
                'admission_date' => now()->subDays(rand(1, 365)),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'date_of_birth' => now()->subYears(rand(10, 18))->subDays(rand(1, 365)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'blood_group' => ['A+', 'B+', 'O+', 'AB+'][array_rand(['A+', 'B+', 'O+', 'AB+'])],
                'religion' => ['Christianity', 'Islam', 'Other'][array_rand(['Christianity', 'Islam', 'Other'])],
                'nationality' => 'Nigerian',
                'state_of_origin' => ['Lagos', 'Abuja', 'Kano', 'Rivers'][array_rand(['Lagos', 'Abuja', 'Kano', 'Rivers'])],
                'address' => $i . ' School Street, Lagos',
                'emergency_contact_name' => 'Parent ' . $lastName,
                'emergency_contact_phone' => '+2348012345678',
                'current_class_id' => rand(1, 6),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}