<?php

namespace App\Providers;

use App\Events\LoginFailed;
use App\Events\UserLoggedIn;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogUserLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserLoggedIn::class => [
            LogUserLogin::class,
        ],
        LoginFailed::class => [
            LogFailedLogin::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
