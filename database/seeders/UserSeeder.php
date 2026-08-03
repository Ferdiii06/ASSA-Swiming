<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default Coach user
        User::updateOrCreate(
            ['email' => 'coach@gmail.com'],
            [
                'name' => 'Coach',
                'password' => Hash::make('password'),
            ]
        );
    }
}
