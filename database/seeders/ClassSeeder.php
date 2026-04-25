<?php
// database/seeders/ClassSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['Grade 1', 'G01', 1, 40],
            ['Grade 2', 'G02', 2, 40],
            ['Grade 3', 'G03', 3, 40],
            ['Grade 4', 'G04', 4, 40],
            ['Grade 5', 'G05', 5, 40],
            ['Grade 6', 'G06', 6, 40],
            ['JSS 1', 'JSS1', 7, 45],
            ['JSS 2', 'JSS2', 8, 45],
            ['JSS 3', 'JSS3', 9, 45],
            ['SSS 1', 'SSS1', 10, 50],
            ['SSS 2', 'SSS2', 11, 50],
            ['SSS 3', 'SSS3', 12, 50],
        ];

        foreach ($classes as $class) {
            DB::table('classes')->insert([
                'school_id' => 1,
                'name' => $class[0],
                'code' => $class[1],
                'grade_level' => $class[2],
                'capacity' => $class[3],
                'status' => 'active',
                'sort_order' => $class[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}