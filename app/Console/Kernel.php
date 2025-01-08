<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application"s command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // EPG verilerini her saat başı güncelle
        $schedule->command("epg:refresh")
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground();

        // Xtream içeriğini her gün gece yarısı güncelle
        $schedule->command("xtream:sync")
            ->dailyAt("00:00")
            ->withoutOverlapping()
            ->runInBackground();

        // Bağlantı loglarını temizle
        $schedule->job(new \App\Jobs\CleanupConnectionLogs)
            ->everyFifteenMinutes()
            ->withoutOverlapping()
            ->runInBackground();

        // Aktivite loglarını temizle
        $schedule->command('activity-logs:cleanup')
            ->daily()
            ->withoutOverlapping()
            ->runInBackground();

        // Eski aktivite loglarını temizle
        $schedule->job(new \App\Jobs\CleanupOldActivityLogs(30))
            ->weekly()
            ->withoutOverlapping()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__."/Commands");

        require base_path("routes/console.php");
    }
}
