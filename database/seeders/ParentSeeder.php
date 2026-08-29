<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('students_spreadsheet.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("File students_spreadsheet.json tidak ditemukan!");
            return;
        }

        $json = File::get($jsonPath);
        $students = json_decode($json, true);

        if (!is_array($students)) {
            $this->command->error("Format JSON tidak valid!");
            return;
        }

        $createdCount = 0;
        $processedPhones = [];

        foreach ($students as $student) {
            $parentName = trim($student['parent_name'] ?? '');
            $phone = trim($student['phone'] ?? '');

            // Skip jika nomor HP kosong atau sudah diproses
            if (empty($phone) || in_array($phone, $processedPhones)) {
                continue;
            }

            // Format email sesuai request: {nomor_hp}@gmail.com
            $email = $phone . '@gmail.com';

            if (empty($parentName)) {
                $parentName = 'Wali ' . ($student['name'] ?? 'Siswa');
            }

            User::updateOrCreate(
                ['phone' => $phone], // Update atau Create berdasarkan no HP
                [
                    'name' => $parentName,
                    'email' => $email,
                    'password' => Hash::make('password123'), // Default password
                    'role' => 'parent',
                    'email_verified_at' => now(),
                ]
            );

            $processedPhones[] = $phone;
            $createdCount++;
        }

        $this->command->info("Berhasil membuat/memperbarui {$createdCount} akun Parent.");
    }
}
