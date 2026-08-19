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
            ['name' => 'Coach Vicky', 'email' => 'vicky@lesrenang.com', 'password' => Hash::make('password'), 'role' => 'coach'],
            ['name' => 'Coach Arin', 'email' => 'arin@lesrenang.com', 'password' => Hash::make('password'), 'role' => 'coach'],
            ['name' => 'Coach Tiwi', 'email' => 'tiwi@lesrenang.com', 'password' => Hash::make('password'), 'role' => 'coach'],
            ['name' => 'Coach Tasya', 'email' => 'tasya@lesrenang.com', 'password' => Hash::make('password'), 'role' => 'coach'],
        ];

        foreach ($coaches as $coach) {
            User::updateOrCreate(
                ['email' => $coach['email']],
                $coach
            );
        }
    }
}
