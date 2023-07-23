<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_dates_can_be_updated()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // Create a user
        $user = User::factory()->create();

        // Simulate user login
        $this->actingAs($user, 'api');
        
        // Create a subscription for the user
        $subscription = Subscription::factory()->create();

        // Create a subscription type
        $subscriptionType = SubscriptionType::factory()->create();

        // New dates
        $newRenewedAt = Carbon::now()->format('Y-m-d');
        $newExpiredAt = Carbon::now()->addMonth()->format('Y-m-d');

        
        // Set up the request data
        $data = [
            'subscription_type_id' => $subscriptionType->id,
            'renewed_at' => "2022-06-15",
            'expired_at' => "2022-07-15"
        ];

        // Make the POST request to create a subscription
        $response = $this->actingAs($user, 'api')->json('POST', "/api/user/{$user->id}/subscription", $data);
        echo $response->getContent();
        $createSubscription = json_decode($response->getContent());
        $response = $this->actingAs($user)
                         ->json('PUT', '/api/user/' . $createSubscription->user_id . '/subscription/' . $createSubscription->id, [
                             'renewed_at' => $newRenewedAt,
                             'expired_at' => $newExpiredAt,
                         ]);
        echo $response->getContent();
        $response->assertStatus(200);
    }
}