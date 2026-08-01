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
                'name' => 'Coach Budi',
                'email' => 'budi@lesrenang.com',
                'phone' => '08123456781',
                'specialization' => 'Basic & Intermediate',
                'bio' => 'Pelatih berpengalaman 5 tahun di bidang renang',
                'is_active' => true
            ],
            [
                'name' => 'Coach Siti',
                'email' => 'siti@lesrenang.com',
                'phone' => '08123456782',
                'specialization' => 'Advanced & Private',
                'bio' => 'Mantan atlet renang nasional',
                'is_active' => true
            ],
            [
                'name' => 'Coach Andi',
                'email' => 'andi@lesrenang.com',
                'phone' => '08123456783',
                'specialization' => 'Basic & Anak-anak',
                'bio' => 'Spesialis renang untuk anak-anak',
                'is_active' => true
            ],
        ];

        foreach ($coaches as $coach) {
            Coach::create($coach);
        }

        $this->command->info('✅ Coach seeder berhasil!');
    }
}
