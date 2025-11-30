<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['label' => 'Administrateur'],
            ['label' => 'Gestionnaire'],
            ['label' => 'Service Technique'],
            ['label' => 'Utilisateur'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
