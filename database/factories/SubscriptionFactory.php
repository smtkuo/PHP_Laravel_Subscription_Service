<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subscription_type_id' => SubscriptionType::factory(),
            'renewed_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addMonth(),
        ];
    }
}