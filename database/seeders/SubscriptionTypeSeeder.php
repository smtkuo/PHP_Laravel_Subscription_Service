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
            'name' => 'Starter',
            'duration' => 1,
            'price' => 199,
            'details' => 'Basic subscription details...',
        ]);
        SubscriptionType::create([
            'name' => 'Standard',
            'duration' => 1,
            'price' => 699,
            'details' => 'Basic subscription details...',
        ]);
        SubscriptionType::create([
            'name' => 'Advanced',
            'duration' => 1,
            'price' => 999,
            'details' => 'Premium subscription details...',
        ]);
    }
}
