<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('order:send-pending-notification')
    ->dailyAt('10:00')
    ->timezone('Asia/Ho_Chi_Minh')
    ->description('Send Pending Email To Admin');
