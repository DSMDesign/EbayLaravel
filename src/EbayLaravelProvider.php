<?php

namespace EbayIntegration\EbayLaravel;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use EbayIntegration\EbayLaravel\Commands\Install;
use EbayIntegration\EbayLaravel\Commands\Republish;
use EbayIntegration\EbayLaravel\Events\UserVerifyEvent;
use EbayIntegration\EbayLaravel\Listeners\SendUserVerifyListener;

class EbayLaravelProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Event for when you create a new user
        Event::listen(
            UserVerifyEvent::class,
            [SendUserVerifyListener::class, 'handle']
        );

        // Load some commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Republish::class,
                Install::class,
            ]);
        }

        // Load skeleton views
        $this->loadViewsFrom(__DIR__ . '/views', 'ebayLaravel');

        // Ebay autentication routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        // Demo ebay test routes (Test Only)
        if (config('ebayLaravel.demo_mode')) {
            $this->loadRoutesFrom(__DIR__ . '/Routes/demo.php');
        }

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publish();
    }

    public function publish()
    {
        // Publish the public folder
        $this->publishes([
            __DIR__ . '/../Publish/Config/' => config_path(''),
        ]);
        // Publish the view to the view folder with the login view and demo
        $this->publishes([
            __DIR__ . '/../Publish/Views/' => resource_path('ebay/'),
        ]);
    }
}
