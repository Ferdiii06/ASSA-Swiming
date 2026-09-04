<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coaches = [
            ['name' => 'Coach Vicky', 'email' => 'coach.vicky@gmail.com', 'password' => Hash::make('VickyRenang123!'), 'role' => 'coach'],
            ['name' => 'Coach Arin', 'email' => 'coach.arin@gmail.com', 'password' => Hash::make('ArinRenang123!'), 'role' => 'coach'],
            ['name' => 'Coach Tiwi', 'email' => 'coach.tiwi@gmail.com', 'password' => Hash::make('TiwiRenang123!'), 'role' => 'coach'],
            ['name' => 'Coach Tasya', 'email' => 'coach.tasya@gmail.com', 'password' => Hash::make('TasyaRenang123!'), 'role' => 'coach'],
            ['name' => 'Coach Abiyu', 'email' => 'coach.abiyu@gmail.com', 'password' => Hash::make('AbiyuRenang123!'), 'role' => 'coach'],
        ];

        foreach ($coaches as $coach) {
            User::updateOrCreate(
                ['email' => $coach['email']],
                $coach
            );
        }
    }
}
