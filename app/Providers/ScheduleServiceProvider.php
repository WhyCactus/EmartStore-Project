<?php

namespace App\Providers;

use App\Jobs\ProcessReport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->Schedule($schedule);
        });
    }

    public function schedule(Schedule $schedule): void
    {
        $schedule->command('orders:send-pending-orders-notification')
            ->dailyAt('10:00');

        $schedule->command('orders:cancel-expired-stripe')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground();

        $schedule->command('orders:send-stripe-payment-warnings')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground();
    }
}
