<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LmsRoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $tutorRole = Role::firstOrCreate(['name' => 'tutor']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@lms.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'phone' => '+12345678901',
                'whatsapp_opted_in' => true,
                'bio' => 'LMS Chief Administrator & Coordinator',
            ]
        );
        $admin->syncRoles([$adminRole]);

        // 2. Tutor User
        $tutor = User::firstOrCreate(
            ['email' => 'tutor@lms.test'],
            [
                'name' => 'Dr. Jane Mitchell',
                'password' => Hash::make('password'),
                'phone' => '+12345678902',
                'whatsapp_opted_in' => true,
                'bio' => 'Senior Instructor and Authority Course Director',
            ]
        );
        $tutor->syncRoles([$tutorRole]);

        // 3. Student User
        $student = User::firstOrCreate(
            ['email' => 'student@lms.test'],
            [
                'name' => 'Alex Johnson',
                'password' => Hash::make('password'),
                'phone' => '+12345678903',
                'whatsapp_opted_in' => true,
                'bio' => 'Enrolled Student',
            ]
        );
        $student->syncRoles([$studentRole]);
    }
}
