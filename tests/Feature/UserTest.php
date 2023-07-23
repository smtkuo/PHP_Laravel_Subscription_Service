<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_information_is_returned_correctly()
    {
        // Create a new user
        $user = User::factory()->create();

        // Log in the user
        $this->actingAs($user, 'api');

        // Send a GET request to the user information endpoint
        $response = $this->json('GET', '/api/user/' . $user->id);
        echo $response->getContent();

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'subscriptions' => [
                '*' => [
                    'id',
                    'user_id',
                    'subscription_type_id',
                    'renewed_at',
                    'expired_at',
                    'created_at',
                    'updated_at'
                ]
            ],
            'transactions' => [
                '*' => [
                    'id',
                    'user_id',
                    'subscription_id',
                    'price',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
}