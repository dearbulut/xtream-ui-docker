<?php

namespace App\Console\Commands;

use App\Services\EpgService;
use Illuminate\Console\Command;

class RefreshEpgCommand extends Command
{
    protected $signature = 'epg:refresh';
    protected $description = 'Refresh EPG data from configured source';

    protected $epgService;

    public function __construct(EpgService $epgService)
    {
        parent::__construct();
        $this->epgService = $epgService;
    }

    public function handle()
    {
        try {
            $this->info('Refreshing EPG data...');
            $this->epgService->refreshData();
            $this->info('EPG data refreshed successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('EPG refresh failed: ' . $e->getMessage());
            return 1;
        }
    }
}
