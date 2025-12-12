<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Http\HttpClientOptions;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('firebase.factory', function ($app) {
            $factory = (new Factory())
                ->withServiceAccount(base_path(config('services.firebase.credentials')));

            if ($databaseUrl = config('services.firebase.database_url')) {
                $factory = $factory->withDatabaseUri($databaseUrl);
            }

            return $factory;
        });


        // Auth
        $this->app->singleton(Auth::class, function ($app) {
            return $app->make('firebase.factory')->createAuth();
        });

        // Database
        $this->app->singleton(Database::class, function ($app) {
            return $app->make('firebase.factory')->createDatabase();
        });

        // Messaging
        $this->app->singleton(Messaging::class, function ($app) {
            return $app->make('firebase.factory')->createMessaging();
        });

        // Storage
        $this->app->singleton(Storage::class, function ($app) {
            return $app->make('firebase.factory')->createStorage();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
