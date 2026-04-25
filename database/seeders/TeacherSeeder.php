<?php
// database/seeders/TeacherSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['Mathematics', 'English', 'Physics', 'Chemistry', 'Biology', 'History', 'Geography', 'Computer Science'];
        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('teachers')->insert([
                'user_id' => 3 + $i, // After superadmin and admin
                'school_id' => 1,
                'staff_id' => 'TCH' . date('Y') . str_pad($i, 3, '0', STR_PAD_LEFT),
                'first_name' => ['John', 'Jane', 'Michael', 'Sarah', 'David'][array_rand(['John', 'Jane', 'Michael', 'Sarah', 'David'])],
                'last_name' => ['Smith', 'Johnson', 'Williams', 'Brown'][array_rand(['Smith', 'Johnson', 'Williams', 'Brown'])],
                'qualification' => 'B.Ed ' . $subjects[array_rand($subjects)],
                'specialization' => $subjects[array_rand($subjects)],
                'joining_date' => now()->subYears(rand(1, 10)),
                'employment_type' => ['permanent', 'contract', 'part-time'][array_rand(['permanent', 'contract', 'part-time'])],
                'salary_grade' => 'Level ' . rand(1, 10),
                'bank_name' => 'Access Bank',
                'account_number' => '123456789' . $i,
                'account_name' => 'Teacher ' . $i,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}