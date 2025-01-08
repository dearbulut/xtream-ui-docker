<?php

namespace App\Console\Commands;

use App\Jobs\CleanupOldActivityLogs as CleanupOldActivityLogsJob;
use Illuminate\Console\Command;

class CleanupOldActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity-logs:cleanup-old {--days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old activity logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        CleanupOldActivityLogsJob::dispatch($days);

        $this->info("Cleanup job dispatched for activity logs older than {$days} days.");
    }
}
