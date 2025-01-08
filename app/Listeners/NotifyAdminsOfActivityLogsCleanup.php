<?php

namespace App\Listeners;

use App\Events\ActivityLogsCleanedUp;
use App\Models\Admin;
use App\Notifications\ActivityLogsCleanupCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminsOfActivityLogsCleanup
{
    public function handle(ActivityLogsCleanedUp $event): void
    {
        Admin::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->each(function ($admin) use ($event) {
            $admin->notify(new ActivityLogsCleanupCompleted($event->count, $event->days));
        });
    }
}
