<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_login_screen_links_to_registration(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Belum punya akun? Daftar');
        $response->assertSee('href="'.route('register').'"', false);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_new_users_must_apply_as_writer_from_profile(): void
    {
        $this->post('/register', [
            'name' => 'Calon Writer',
            'email' => 'calon-writer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'calon-writer@example.com',
            'role' => 'user',
            'writer_status' => 'not_requested',
        ]);
    }
}
