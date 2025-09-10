<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Dummy Students
        User::create([
            'name' => 'Student One',
            'email' => 'student1@gmail.com',
            'password' => Hash::make('student123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Student Two',
            'email' => 'student2@gmail.com',
            'password' => Hash::make('student123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Student Three',
            'email' => 'student3@gmail.com',
            'password' => Hash::make('student123'),
            'is_admin' => false,
        ]);
    }
}
