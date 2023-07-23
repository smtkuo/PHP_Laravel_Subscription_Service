<?php

namespace Tests\Feature;

use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class CreateSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_subscription()
    {
        // Create a user
        $user = User::factory()->create();

        // Simulate user login
        $this->actingAs($user, 'api');
        
        // Create a subscription type
        $subscriptionType = SubscriptionType::factory()->create();

        // New dates
        $newRenewedAt = Carbon::now()->format('Y-m-d');
        $newExpiredAt = Carbon::now()->addMonth()->format('Y-m-d');

        // Set up the request data
        $data = [
            'subscription_type_id' => $subscriptionType->id,
            'renewed_at' => $newRenewedAt,
            'expired_at' => $newExpiredAt
        ];

        // Make the POST request to create a subscription
        $response = $this->actingAs($user, 'api')->json('POST', "/api/user/{$user->id}/subscription", $data);

        echo $response->getContent();


        // Assert that the subscription was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', $data);
    }
}