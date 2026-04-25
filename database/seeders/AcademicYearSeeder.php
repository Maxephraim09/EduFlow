<?php
// database/seeders/AcademicYearSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['2022/2023', '2022-09-01', '2023-07-31', false, false],
            ['2023/2024', '2023-09-01', '2024-07-31', false, false],
            ['2024/2025', '2024-09-01', '2025-07-31', true, true],
        ];

        foreach ($years as $year) {
            DB::table('academic_years')->insert([
                'school_id' => 1,
                'name' => $year[0] . ' Academic Year',
                'code' => $year[0],
                'start_date' => $year[1],
                'end_date' => $year[2],
                'is_current' => $year[3],
                'is_default' => $year[4],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}