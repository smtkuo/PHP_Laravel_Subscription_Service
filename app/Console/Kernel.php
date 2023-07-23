<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CreateSubscriptionCommand;
use App\Console\Commands\UpdateSubscriptionCommand;
use App\Console\Commands\DeleteSubscriptionCommand;
use App\Console\Commands\RenewSubscriptionCommand;
use App\Jobs\RenewSubscriptionsJob; 

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateSubscriptionCommand::class,
        UpdateSubscriptionCommand::class,
        DeleteSubscriptionCommand::class,
        RenewSubscriptionCommand::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job('App\Jobs\RenewSubscriptionsJob')->everySecond();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
