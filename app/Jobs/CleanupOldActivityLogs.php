<?php

namespace App\Jobs;

use App\Services\ActivityLogService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CleanupOldActivityLogs implements ShouldQueue
{
    use Queueable;

    protected $days;

    public function __construct(int $days = 30)
    {
        $this->days = $days;
    }

    public function handle(ActivityLogService $activityLogService): void
    {
        $activityLogService->cleanup($this->days);
    }
}
