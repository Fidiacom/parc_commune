<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Principal',
                'username' => 'admin',
                'email' => 'admin@jamaycom.ma',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ],
            [
                'name' => 'Gestionnaire Parc',
                'username' => 'gestionnaire',
                'email' => 'gestionnaire@jamaycom.ma',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ],
            [
                'name' => 'Utilisateur Test',
                'username' => 'user',
                'email' => 'user@jamaycom.ma',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
