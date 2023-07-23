<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase; // This trait is used to reset the database after each test

    public function test_registration_requires_name()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $response = $this->json('POST', '/api/register', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_requires_email()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $response = $this->json('POST', '/api/register', [
            'name' => 'Test User',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_requires_password()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $response = $this->json('POST', '/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class); 

        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ];

        $response = $this->json('POST', route('api.register'), $userData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => 1,
                'message' => 'Your registration has been created',
            ]);
    }
}