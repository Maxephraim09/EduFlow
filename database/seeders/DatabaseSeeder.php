<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SchoolSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            ClassSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            ParentSeeder::class,
            FeePaymentSeeder::class,
            EventSeeder::class,
            AttendanceSeeder::class,
            ExamSeeder::class,
            ResultSeeder::class,
            LibrarySeeder::class,
            TransportSeeder::class,
            HostelSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}