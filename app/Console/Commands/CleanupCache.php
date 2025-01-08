<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CleanupCache extends Command
{
    protected $signature = "xtream:cleanup-cache";
    protected $description = "Önbelleği temizle";

    public function handle()
    {
        $this->info("Önbellek temizleme işlemi başlatıldı...");

        try {
            // Xtream önbelleğini temizle
            $keys = Cache::get("xtream_*");
            if ($keys) {
                foreach ($keys as $key) {
                    Cache::forget($key);
                }
            }

            // EPG önbelleğini temizle
            $keys = Cache::get("epg_*");
            if ($keys) {
                foreach ($keys as $key) {
                    Cache::forget($key);
                }
            }

            $this->info("Önbellek başarıyla temizlendi!");
            return 0;
        } catch (\Exception $e) {
            $this->error("Bir hata oluştu: " . $e->getMessage());
            return 1;
        }
    }
}
