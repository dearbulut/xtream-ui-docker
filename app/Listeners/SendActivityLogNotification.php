<?php

namespace App\Listeners;

use App\Events\ActivityLogged;
use App\Models\Admin;
use App\Notifications\ActivityLogNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendActivityLogNotification
{
    public function handle(ActivityLogged $event): void
    {
        // Tüm admin kullanıcılarına bildirim gönder
        Admin::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->each(function ($admin) use ($event) {
            if ($admin->shouldNotifyOnActivityLog($event->activityLog)) {
                $admin->notify(new ActivityLogNotification($event->activityLog));
            }
        });
    }
}
