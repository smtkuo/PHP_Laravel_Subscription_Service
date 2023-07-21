<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionType;


class SubscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionType::create([
            'name' => 'Basic',
            'price' => 9.99,
            'duration' => 30,
            'details' => 'Basic subscription details...',
        ]);

        SubscriptionType::create([
            'name' => 'Premium',
            'price' => 19.99,
            'duration' => 30,
            'details' => 'Premium subscription details...',
        ]);
    }
}
