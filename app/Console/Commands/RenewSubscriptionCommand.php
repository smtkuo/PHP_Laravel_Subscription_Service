<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;
use Carbon\Carbon;

class RenewSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:renew {subscriptionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew a subscription';

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
            // We'll just update the 'renewed_at' and 'expired_at' fields here for simplicity
            $this->subscriptionService->update($subscriptionId, Carbon::now(), Carbon::now()->addMonth());
            $this->info('Subscription renewed successfully.');

            return 0;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            $this->error('An error occurred while renewing the subscription.');

            return 1;
        }
    }
}