<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'surname' => 'System',
            'cedula' => '000000000',
            'birthdate' => '1990-01-01',
            'email' => 'admin@aventones.com',
            'phone' => '00000000',
            'password' => 'admin123',
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
