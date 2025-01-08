<?php

namespace App\Providers;

use App\Events\ActivityLogged;
use App\Events\ActivityLogsCleanedUp;
use App\Listeners\NotifyAdminsOfActivityLogsCleanup;
use App\Listeners\SendActivityLogNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogPlaylistConnection',
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogPlaylistConnection',
            'App\Listeners\LogSuccessfulLogout',
        ],
        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],
        ActivityLogged::class => [
            SendActivityLogNotification::class,
        ],
        ActivityLogsCleanedUp::class => [
            NotifyAdminsOfActivityLogsCleanup::class,
        ],

        // Model aktiviteleri
        "Illuminate\Database\Events\Created" => [
            "App\Listeners\LogModelCreated",
        ],
        "Illuminate\Database\Events\Updated" => [
            "App\Listeners\LogModelUpdated",
        ],
        "Illuminate\Database\Events\Deleted" => [
            "App\Listeners\LogModelDeleted",
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        \App\Models\ConnectionLog::observe(\App\Observers\ConnectionLogObserver::class);

        // Model aktivitelerini izle
        \App\Models\Channel::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Movie::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Series::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Season::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Episode::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Playlist::observe(\App\Observers\ActivityLogObserver::class);
        \App\Models\Bouquet::observe(\App\Observers\ActivityLogObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
