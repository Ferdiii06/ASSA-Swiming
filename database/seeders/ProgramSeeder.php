<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Basic 1',
                'description' => 'Dasar renang untuk pemula. Belajar mengapung dan gerakan dasar.',
                'price_per_session' => 150000,
                'price_monthly' => 500000,
                'duration_months' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Basic 2',
                'description' => 'Lanjutan Basic 1. Belajar gaya bebas dasar.',
                'price_per_session' => 150000,
                'price_monthly' => 500000,
                'duration_months' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Intermediate',
                'description' => 'Level menengah. Gaya dada dan gaya punggung.',
                'price_per_session' => 175000,
                'price_monthly' => 600000,
                'duration_months' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Advanced',
                'description' => 'Level mahir. Teknik lanjutan dan kompetisi.',
                'price_per_session' => 200000,
                'price_monthly' => 750000,
                'duration_months' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Private Class',
                'description' => 'Kelas privat 1-on-1 dengan pelatih.',
                'price_per_session' => 350000,
                'price_monthly' => 1200000,
                'duration_months' => 1,
                'is_active' => true
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }

        $this->command->info('✅ Program seeder berhasil!');
    }
}
