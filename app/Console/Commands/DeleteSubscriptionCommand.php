<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;

class DeleteSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:delete {subscriptionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a subscription';

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

        try {
            $this->subscriptionService->delete($subscriptionId);
            $this->info('Subscription deleted successfully.');

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred while deleting the subscription.');

            return 1;
        }
    }
}