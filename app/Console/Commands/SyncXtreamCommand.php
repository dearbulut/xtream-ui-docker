<?php

namespace App\Console\Commands;

use App\Services\XtreamService;
use Illuminate\Console\Command;

class SyncXtreamCommand extends Command
{
    protected $signature = 'xtream:sync {--type=all : Type of content to sync (all, categories, channels, movies, series)}';
    protected $description = 'Sync content from Xtream API';

    protected $xtreamService;

    public function __construct(XtreamService $xtreamService)
    {
        parent::__construct();
        $this->xtreamService = $xtreamService;
    }

    public function handle()
    {
        $type = $this->option('type');

        try {
            $this->info('Authenticating with Xtream API...');
            $this->xtreamService->authenticate();

            switch ($type) {
                case 'categories':
                    $this->info('Syncing categories...');
                    $this->xtreamService->syncCategories();
                    break;

                case 'channels':
                    $this->info('Syncing channels...');
                    $this->xtreamService->syncChannels();
                    break;

                case 'movies':
                    $this->info('Syncing movies...');
                    $this->xtreamService->syncMovies();
                    break;

                case 'series':
                    $this->info('Syncing series...');
                    $this->xtreamService->syncSeries();
                    break;

                case 'all':
                default:
                    $this->info('Syncing all content...');
                    $this->xtreamService->syncCategories();
                    $this->xtreamService->syncChannels();
                    $this->xtreamService->syncMovies();
                    $this->xtreamService->syncSeries();
                    break;
            }

            $this->info('Sync completed successfully!');
        } catch (\Exception $e) {
            $this->error('Sync failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
