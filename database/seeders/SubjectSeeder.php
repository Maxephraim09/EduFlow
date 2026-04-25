<?php
// database/seeders/SubjectSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['Mathematics', 'MTH101', 'core', 'theory', 3],
            ['English Language', 'ENG101', 'core', 'theory', 3],
            ['Physics', 'PHY101', 'core', 'both', 3],
            ['Chemistry', 'CHM101', 'core', 'both', 3],
            ['Biology', 'BIO101', 'core', 'both', 3],
            ['History', 'HIS101', 'core', 'theory', 2],
            ['Geography', 'GEO101', 'core', 'theory', 2],
            ['Computer Science', 'CSC101', 'core', 'practical', 3],
            ['Economics', 'ECO101', 'elective', 'theory', 2],
            ['Literature', 'LIT101', 'elective', 'theory', 2],
            ['Government', 'GOV101', 'elective', 'theory', 2],
            ['Commerce', 'COM101', 'elective', 'theory', 2],
            ['Accounting', 'ACC101', 'elective', 'theory', 2],
            ['Agricultural Science', 'AGR101', 'elective', 'both', 2],
            ['French', 'FRN101', 'elective', 'theory', 2],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'school_id' => 1,
                'name' => $subject[0],
                'code' => $subject[1],
                'category' => $subject[2],
                'subject_type' => $subject[3],
                'credit_hours' => $subject[4],
                'passing_marks' => 40,
                'maximum_marks' => 100,
                'minimum_marks' => 0,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}