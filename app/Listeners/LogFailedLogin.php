<?php

namespace App\Listeners;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
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
        $user = User::where('email', $event->email)->first();

        LoginLog::create([
            'user_id' => $user ? $user->id : null,
            'email' => $event->email,
            'ip_address' => $event->ipAddress,
            'user_agent' => $event->userAgent,
            'login_method' => 'web',
            'is_successful' => false,
            'failure_reason' => $event->reason,
            'logged_in_at' => now(),
        ]);
    }
}
