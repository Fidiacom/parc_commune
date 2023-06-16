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



        $role1 = Role::where('label', '=', 'Admin')->first()->id;
        $user1 = new User;
        $user1->name = 'Admin';
        $user1->email = 'admin@email.com';
        $user1->password = Hash::make('password');
        $user1->role_id = $role;
        $user1->save();

    }
}
