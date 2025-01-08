<?php

namespace App\Services;

use App\Events\ActivityLogsCleanedUp;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Event;

class ActivityLogService
{
    public function cleanup(int $days = 30): int
    {
        $count = ActivityLog::where('created_at', '<', now()->subDays($days))->count();
        ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        Event::dispatch(new ActivityLogsCleanedUp($count, $days));

        return $count;
    }

    public function getStats(): array
    {
        return [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'week' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month' => ActivityLog::whereMonth('created_at', now()->month)->count(),
        ];
    }
}