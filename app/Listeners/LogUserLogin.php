<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        try {
            LoginLog::create([
                'user_id' => $event->user->id,
                'ip_address' => $event->ipAddress,
                'user_agent' => $event->userAgent,
                'logged_in_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create login log: ' . $e->getMessage());
        }
    }
}
