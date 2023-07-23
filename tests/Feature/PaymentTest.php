<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_made()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->json('POST', "/api/user/{$user->id}/transaction", [
            'subscription_id' => $subscription->id,
            'price' => 100,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'subscription_id',
            'price',
            'created_at',
            'updated_at',
        ]);
    }
}