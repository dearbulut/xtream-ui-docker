<?php

namespace App\Providers;

use App\Services\SettingService;
use App\Services\XtreamService;
use App\Services\EpgService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingService::class, function ($app) {
            return new SettingService();
        });

        $this->app->singleton(XtreamService::class, function ($app) {
            return new XtreamService($app->make(SettingService::class));
        });

        $this->app->singleton(EpgService::class, function ($app) {
            return new EpgService($app->make(SettingService::class));
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
