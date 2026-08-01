<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat roles
        $admin = Role::create(['name' => 'admin']);
        $parent = Role::create(['name' => 'parent']);
        $coach = Role::create(['name' => 'coach']);

        // Buat admin
        $adminUser = User::create([
            'name' => 'Admin Les Renang',
            'email' => 'admin@lesrenang.com',
            'password' => Hash::make('password123'),
            'phone' => '08123456789',
            'role' => 'admin',
        ]);
        $adminUser->assignRole('admin');

        // Buat sample parent
        $parentUser = User::create([
            'name' => 'Ibu Ani',
            'email' => 'parent@example.com',
            'password' => Hash::make('password123'),
            'phone' => '08123456788',
            'role' => 'parent',
        ]);
        $parentUser->assignRole('parent');

        // Buat sample coach
        $coachUser = User::create([
            'name' => 'Coach Budi',
            'email' => 'coach@example.com',
            'password' => Hash::make('password123'),
            'phone' => '08123456787',
            'role' => 'coach',
        ]);
        $coachUser->assignRole('coach');

        $this->command->info('✅ Roles and users created successfully!');
        $this->command->info('Admin: admin@lesrenang.com / password123');
        $this->command->info('Parent: parent@example.com / password123');
        $this->command->info('Coach: coach@example.com / password123');
    }
}
