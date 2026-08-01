<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Coach;
use App\Models\Program;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            [
                'coach_id' => 1, // Coach Budi
                'program_id' => 1, // Basic 1
                'day' => 'Monday',
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'max_students' => 10,
                'is_active' => true
            ],
            [
                'coach_id' => 1,
                'program_id' => 2, // Basic 2
                'day' => 'Wednesday',
                'start_time' => '15:00:00',
                'end_time' => '17:00:00',
                'max_students' => 10,
                'is_active' => true
            ],
            [
                'coach_id' => 2, // Coach Siti
                'program_id' => 3, // Intermediate
                'day' => 'Tuesday',
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'max_students' => 8,
                'is_active' => true
            ],
            [
                'coach_id' => 2,
                'program_id' => 5, // Private
                'day' => 'Friday',
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'max_students' => 2,
                'is_active' => true
            ],
            [
                'coach_id' => 3, // Coach Andi
                'program_id' => 1, // Basic 1
                'day' => 'Saturday',
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'max_students' => 8,
                'is_active' => true
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }

        $this->command->info('✅ Schedule seeder berhasil!');
    }
}
