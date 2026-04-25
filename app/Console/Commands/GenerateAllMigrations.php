<?php
// app/Console/Commands/GenerateAllMigrations.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateAllMigrations extends Command
{
    protected $signature = 'make:all-migrations';
    protected $description = 'Generate all migrations for School Management System';

    public function handle()
    {
        $migrations = [
            // Core System Tables
            'create_schools_table',
            'create_users_table',
            'create_roles_table',
            'create_permissions_table',
            'create_role_has_permissions_table',
            'create_model_has_roles_table',
            'create_activity_logs_table',
            
            // Academic Structure Tables
            'create_academic_years_table',
            'create_terms_table',
            'create_classes_table',
            'create_sections_table',
            
            // Subjects & Curriculum
            'create_subjects_table',
            'create_class_subjects_table',
            'create_syllabus_table',
            
            // Student Management
            'create_students_table',
            'create_parents_table',
            'create_student_parents_table',
            'create_student_promotions_table',
            
            // Teacher Management
            'create_teachers_table',
            'create_teacher_assignments_table',
            
            // Attendance Management
            'create_student_attendance_table',
            'create_teacher_attendance_table',
            'create_leave_requests_table',
            
            // Examination & Assessment
            'create_exam_types_table',
            'create_exams_table',
            'create_exam_subjects_table',
            'create_exam_results_table',
            'create_continuous_assessments_table',
            'create_ca_scores_table',
            'create_term_results_table',
            'create_term_summaries_table',
            'create_report_cards_table',
            'create_grade_scales_table',
            
            // Timetable
            'create_timetables_table',
            
            // Fee Management
            'create_fee_categories_table',
            'create_fee_structures_table',
            'create_fee_payments_table',
            'create_invoices_table',
            'create_invoice_items_table',
            
            // Library Management
            'create_library_categories_table',
            'create_books_table',
            'create_book_issues_table',
            'create_library_settings_table',
            
            // Transport Management
            'create_bus_routes_table',
            'create_buses_table',
            'create_bus_stops_table',
            'create_student_transport_table',
            
            // Hostel Management
            'create_hostels_table',
            'create_hostel_rooms_table',
            'create_hostel_allocations_table',
            'create_hostel_attendance_table',
            
            // Communication
            'create_announcements_table',
            'create_notifications_table',
            'create_messages_table',
            
            // Events
            'create_events_table',
            'create_event_participants_table',
            
            // Inventory
            'create_inventory_categories_table',
            'create_inventory_items_table',
            'create_inventory_transactions_table',
            
            // HR & Payroll
            'create_staff_table',
            'create_payrolls_table',
            
            // Online Learning
            'create_online_courses_table',
            'create_course_enrollments_table',
            
            // Multi-School
            'create_school_branches_table',
            'create_student_transfers_table',
            
            // System
            'create_backups_table',
            'create_school_settings_table',
        ];

        foreach ($migrations as $migration) {
            $this->call('make:migration', [
                'name' => $migration
            ]);
        }

        $this->info('All migrations created successfully!');
    }
}