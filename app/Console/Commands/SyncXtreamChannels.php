<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\XtreamService;
use Illuminate\Support\Facades\Cache;

class SyncXtreamChannels extends Command
{
    protected $signature = "xtream:sync-channels";
    protected $description = "Xtream API'den kanal listesini senkronize et";

    protected $xtreamService;

    public function __construct(XtreamService $xtreamService)
    {
        parent::__construct();
        $this->xtreamService = $xtreamService;
    }

    public function handle()
    {
        $this->info("Kanal senkronizasyonu başlatıldı...");

        try {
            // Önbelleği temizle
            $this->xtreamService->clearCache();

            // Canlı yayın kategorilerini al
            $categories = $this->xtreamService->getLiveCategories();
            if (!$categories) {
                $this->error("Kategoriler alınamadı!");
                return 1;
            }

            $this->info("Kategoriler alındı: " . count($categories));

            // Her kategori için kanalları al
            $totalChannels = 0;
            foreach ($categories as $category) {
                $channels = $this->xtreamService->getLiveStreams($category["category_id"]);
                if ($channels) {
                    $totalChannels += count($channels);
                    $this->info("Kategori: {$category["category_name"]} - {$totalChannels} kanal");
                }
            }

            $this->info("Senkronizasyon tamamlandı!");
            $this->info("Toplam kategori: " . count($categories));
            $this->info("Toplam kanal: " . $totalChannels);

            return 0;
        } catch (\Exception $e) {
            $this->error("Bir hata oluştu: " . $e->getMessage());
            return 1;
        }
    }
}
