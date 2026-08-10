<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coach;

class CoachSeeder extends Seeder
{
    public function run(): void
    {
        $coaches = [
            [
                'name' => 'Coach Vicky',
                'email' => 'vicky@lesrenang.com',
                'phone' => '08111111111',
                'specialization' => 'All Levels',
                'bio' => 'Coach Vicky',
                'is_active' => true
            ],
            [
                'name' => 'Coach Arin',
                'email' => 'arin@lesrenang.com',
                'phone' => '08222222222',
                'specialization' => 'All Levels',
                'bio' => 'Coach Arin',
                'is_active' => true
            ],
            [
                'name' => 'Coach Tiwi',
                'email' => 'tiwi@lesrenang.com',
                'phone' => '08333333333',
                'specialization' => 'All Levels',
                'bio' => 'Coach Tiwi',
                'is_active' => true
            ],
            [
                'name' => 'Coach Tasya',
                'email' => 'tasya@lesrenang.com',
                'phone' => '08444444444',
                'specialization' => 'All Levels',
                'bio' => 'Coach Tasya',
                'is_active' => true
            ],
        ];

        foreach ($coaches as $coach) {
            Coach::create($coach);
        }

        $this->command->info('✅ Coach seeder berhasil!');
    }
}
