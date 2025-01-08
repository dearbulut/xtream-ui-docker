<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EpgService;

class CacheEpgData extends Command
{
    protected $signature = "xtream:cache-epg";
    protected $description = "EPG verilerini önbelleğe al";

    protected $epgService;

    public function __construct(EpgService $epgService)
    {
        parent::__construct();
        $this->epgService = $epgService;
    }

    public function handle()
    {
        $this->info("EPG verilerini önbelleğe alma işlemi başlatıldı...");

        try {
            // Tüm EPG verilerini al ve önbelleğe kaydet
            $data = $this->epgService->getEpgData();

            if ($data === null) {
                $this->error("EPG verilerini alırken bir hata oluştu!");
                return 1;
            }

            $this->info("EPG verileri başarıyla önbelleğe alındı.");
            $this->info("Toplam program sayısı: " . count($data));

            return 0;
        } catch (\Exception $e) {
            $this->error("Bir hata oluştu: " . $e->getMessage());
            return 1;
        }
    }
}
