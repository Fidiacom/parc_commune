<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed admin user
        User::create([
            'name' => 'Admin Principal',
            'username' => 'admin',
            'email' => 'admin@jamaycom.ma',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
    }
}
