<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_subscription()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a subscription for the user
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        // Act as the user
        $this->actingAs($user, 'api');

        // Send a DELETE request to the endpoint
        $response = $this->json('DELETE', "/api/user/{$subscription->id}/subscription");

        // Assert the subscription was deleted
        $response->assertStatus(200);
    }
}