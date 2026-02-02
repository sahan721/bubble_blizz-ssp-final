<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminLoginOnlyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_with_correct_password_works(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin', // keep your project role field
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'admin1234',
        ]);

        // most Laravel apps redirect after login (302)
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_login_with_wrong_password_fails(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-pass',
        ]);

        // should stay unauthenticated
        $response->assertStatus(302);
        $this->assertGuest();
    }

    public function test_login_form_submission_route_exists(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
}
