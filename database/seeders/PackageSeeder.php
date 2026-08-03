<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::create([
            'name' => 'Paket 1 Bulan',
            'price' => 250000,
            'duration_months' => 1,
            'description' => 'Paket latihan renang reguler selama 1 bulan penuh (4x pertemuan).'
        ]);

        Package::create([
            'name' => 'Paket 3 Bulan (Hemat)',
            'price' => 700000,
            'duration_months' => 3,
            'description' => 'Paket latihan renang selama 3 bulan. Lebih hemat dan hasil lebih terukur.'
        ]);

        Package::create([
            'name' => 'Paket 6 Bulan (Pro)',
            'price' => 1300000,
            'duration_months' => 6,
            'description' => 'Paket latihan intensif setengah tahun. Direkomendasikan untuk pembinaan prestasi.'
        ]);
    }
}
