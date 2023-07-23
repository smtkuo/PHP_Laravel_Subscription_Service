<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SubscriptionService;
use Carbon\Carbon;

class RenewSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SubscriptionService $subscriptionService)
    {
        // Get all subscriptions that are due for renewal
        $subscriptions = $subscriptionService->getSubscriptionsDueForRenewal();
        foreach ($subscriptions as $subscription) {
            // Renew the subscription
            $subscriptionService->update($subscription->user_id, $subscription->id, Carbon::now(), Carbon::now()->addMonth());

        }
    }
}