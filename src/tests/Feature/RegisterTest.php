<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_validation_error_when_name_is_missing()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['name']);
    }
    /** @test */
    public function registration_fails_when_email_is_missing()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
    /** @test */
    public function registration_fails_when_password_is_missing()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }
    /** @test */
    public function password_shorter_than_8_characters_shows_validation_error()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password']);
    }
    /** @test */
    public function password_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpass',
        ]);

        $response->assertSessionHasErrors('password');
    }
    /** @test */
    public function user_can_register_and_redirected_to_profile_setup()
    {
        $formData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $formData);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'テストユーザー',
        ]);

        $response->assertRedirect('/mypage/profile');

        $this->assertAuthenticated();
    }
}
