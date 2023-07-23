<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Log;

class CreateSubscriptionCommand extends Command
{
    protected $signature = 'subscription:create {userId} {subscriptionTypeId}';

    protected $description = 'Create a new subscription for a user';

    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();

        $this->subscriptionService = $subscriptionService;
    }

    public function handle()
    {
        $userId = $this->argument('userId');
        $subscriptionTypeId = $this->argument('subscriptionTypeId');

        try {
            $subscription = $this->subscriptionService->create($userId, $subscriptionTypeId, now(), now()->addMonth());

            $this->info('Subscription created successfully');
            Log::info('Subscription created successfully: ', ['subscription' => $subscription]);
        } catch (\Exception $e) {
            $this->error('Failed to create subscription: ' . $e->getMessage());
            Log::error('Failed to create subscription: ', ['error' => $e->getMessage()]);
        }
    }
}