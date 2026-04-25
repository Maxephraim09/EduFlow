<?php
// database/seeders/EventSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'School Opening Ceremony',
                'description' => 'Welcome back to school for the new academic year',
                'event_type' => 'academic',
                'start_datetime' => now()->addDays(5),
                'end_datetime' => now()->addDays(5),
                'venue' => 'School Hall',
                'status' => 'scheduled',
                'color' => '#4e73df',
            ],
            [
                'title' => 'Parent-Teacher Conference',
                'description' => 'Meet with teachers to discuss student progress',
                'event_type' => 'meeting',
                'start_datetime' => now()->addDays(15),
                'end_datetime' => now()->addDays(15),
                'venue' => 'School Auditorium',
                'status' => 'scheduled',
                'color' => '#1cc88a',
            ],
            [
                'title' => 'Sports Day',
                'description' => 'Annual inter-house sports competition',
                'event_type' => 'sports',
                'start_datetime' => now()->addDays(30),
                'end_datetime' => now()->addDays(31),
                'venue' => 'Sports Field',
                'status' => 'scheduled',
                'color' => '#f6c23e',
            ],
            [
                'title' => 'Mid-Term Break',
                'description' => 'School closed for mid-term break',
                'event_type' => 'holiday',
                'start_datetime' => now()->addDays(45),
                'end_datetime' => now()->addDays(49),
                'venue' => null,
                'status' => 'scheduled',
                'color' => '#e74a3b',
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->insert([
                'school_id' => 1,
                'title' => $event['title'],
                'description' => $event['description'],
                'event_type' => $event['event_type'],
                'start_datetime' => $event['start_datetime'],
                'end_datetime' => $event['end_datetime'],
                'venue' => $event['venue'],
                'status' => $event['status'],
                'color' => $event['color'],
                'is_public' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}