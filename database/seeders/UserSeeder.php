<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin1@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // Organizer user
        User::create([
            'name' => 'Organizer User',
            'email' => 'organizer1@example.com',
            'password' => Hash::make('123456'),
            'role' => 'organizer',
        ]);

        // Volunteer user
        User::create([
            'name' => 'Volunteer User',
            'email' => 'volunteer1@example.com',
            'password' => Hash::make('123456'),
            'role' => 'volunteer',
        ]);
    }
}
