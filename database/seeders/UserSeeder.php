<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed admin user. Existing account is left as is (password not reset).
        $adminRole = Role::where('label', 'Administrateur')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'admin@jamaycom.ma'],
            [
                'name' => 'Admin Principal',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );
    }
}
