<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;

class UpdateSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:update {subscriptionId} {renewedAt} {expiredAt} {subscriptionTypeId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a subscription with a new type';

    /**
     * The subscription service instance.
     *
     * @var SubscriptionService
     */
    protected $subscriptionService;

    /**
     * Create a new command instance.
     *
     * @param SubscriptionService $subscriptionService
     * @return void
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();

        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptionId = $this->argument('subscriptionId');
        $renewedAt = $this->argument('renewedAt');
        $expiredAt = $this->argument('expiredAt');
        $subscriptionTypeId = $this->argument('subscriptionTypeId');

        try {
            $this->subscriptionService->update($subscriptionId, $renewedAt, $expiredAt, $subscriptionTypeId);
            $this->info('Subscription updated successfully.');

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred while updating the subscription.');

            return 1;
        }
    }
}