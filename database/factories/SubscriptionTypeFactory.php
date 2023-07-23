<?php

namespace Database\Factories;

use App\Models\SubscriptionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubscriptionType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Starter',
            'duration' => 1,
            'price' => 199,
            'details' => 'Basic subscription details...',
        ];
    }
}