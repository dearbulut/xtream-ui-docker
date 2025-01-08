<?php

namespace App\Jobs;

use App\Models\ConnectionLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class CleanupConnectionLogs implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        // 1 saatten eski bağlantıları sonlandır
        ConnectionLog::where('connected_at', '<=', now()->subHour())
            ->whereNull('disconnected_at')
            ->each(function ($log) {
                $log->update(['disconnected_at' => now()]);
            });

        // 30 günden eski logları sil
        ConnectionLog::where('created_at', '<=', now()->subDays(30))->delete();

        // Cache'i temizle
        Cache::tags(['playlist_connections'])->flush();
    }
}
