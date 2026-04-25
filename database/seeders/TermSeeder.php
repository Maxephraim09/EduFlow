<?php
// database/seeders/TermSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        $academicYearId = DB::table('academic_years')->where('is_current', true)->first()->id;
        
        $terms = [
            ['First Term', 1, '2024-09-01', '2024-12-15', true],
            ['Second Term', 2, '2025-01-08', '2025-04-05', false],
            ['Third Term', 3, '2025-04-28', '2025-07-31', false],
        ];

        foreach ($terms as $term) {
            DB::table('terms')->insert([
                'academic_year_id' => $academicYearId,
                'name' => $term[0],
                'sequence' => $term[1],
                'start_date' => $term[2],
                'end_date' => $term[3],
                'is_current' => $term[4],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}