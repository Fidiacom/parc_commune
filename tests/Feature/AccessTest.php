<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_service_technique_settings_are_blocked_for_simple_users(): void
    {
        $user = User::factory()->role('Utilisateur')->create();

        $this->actingAs($user)->get(route('serviceTechnique.setting'))->assertForbidden();
    }

    public function test_service_technique_settings_are_open_to_admins(): void
    {
        $this->seed();
        $admin = User::where('email', 'admin@jamaycom.ma')->firstOrFail();

        $this->actingAs($admin)->get(route('serviceTechnique.setting'))->assertOk();
    }
}
