<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        ActivityLog::create([
            'user_id' => $event->user?->id,
            'type' => 'login_failed',
            'description' => 'Failed login attempt',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => [
                'credentials' => $event->credentials,
            ],
        ]);
    }
}
