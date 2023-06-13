<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('label', '=', 'Service Technique')->first()->id;
        $user = new User;
        $user->name = 'Service Technique';
        $user->email = 'Servicetechnique@email.com';
        $user->password = Hash::make('password');
        $user->role_id = $role;
        $user->save();

    }
}
