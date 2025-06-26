<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_check_user_returns_true_for_existing_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/check-user', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'exists' => true,
                    'message' => 'User found',
                ]);
    }

    public function test_check_user_returns_false_for_new_user(): void
    {
        $response = $this->post('/check-user', [
            'email' => 'newuser@example.com',
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'exists' => false,
                    'message' => 'You are a new user. You need to register first.',
                ]);
    }

    public function test_check_user_validates_email_format(): void
    {
        $response = $this->post('/check-user', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
