<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use App\Events\ActivityLogged;
use App\Events\ActivityLogBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessActivityLog implements ShouldQueue
{
    use Queueable;

    protected $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function handle(): void
    {
        // Event'leri tetikle
        event(new ActivityLogged($this->activityLog));
        event(new ActivityLogBroadcast($this->activityLog));
    }
}
