<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_INITIAL_EMAIL', 'admin@gmail.com');
        $password = env('ADMIN_INITIAL_PASSWORD');

        if (empty($password)) {
            // Strong fallback for non-production environments
            $password = app()->environment('local') ? 'admin123' : Str::password(20);
        }

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Administrator',
                'phone' => env('ADMIN_INITIAL_PHONE', '08079730678'),
                'role' => 'super_admin',
                'password' => Hash::make($password),
            ]
        );
    }
}
