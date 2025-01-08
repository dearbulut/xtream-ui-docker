<?php

namespace App\Observers;

use App\Models\ConnectionLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ConnectionLogObserver
{
    public function creating(ConnectionLog $connectionLog): void
    {
        // IP bilgilerini al
        try {
            $response = Http::get("http://ip-api.com/json/{$connectionLog->ip_address}");
            if ($response->successful()) {
                $data = $response->json();
                $connectionLog->country = $data['country'] ?? null;
                $connectionLog->city = $data['city'] ?? null;
                $connectionLog->isp = $data['isp'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("IP info fetch failed: " . $e->getMessage());
        }

        // VPN kontrolü
        try {
            $response = Http::get("https://vpnapi.io/api/{$connectionLog->ip_address}?key=" . config("services.vpnapi.key"));
            if ($response->successful()) {
                $data = $response->json();
                $connectionLog->is_vpn = $data['security']['vpn'] || $data['security']['proxy'] || $data['security']['tor'];
            }
        } catch (\Exception $e) {
            \Log::error("VPN check failed: " . $e->getMessage());
        }

        // Bağlantı sayısını artır
        Cache::increment("playlist_connections:{$connectionLog->playlist_id}");
    }

    public function created(ConnectionLog $connectionLog): void
    {
        // Bağlantı bilgilerini cache'e ekle
        Cache::put(
            "playlist_connection:{$connectionLog->playlist_id}:{$connectionLog->ip_address}",
            $connectionLog->id,
            300
        );
    }

    public function updating(ConnectionLog $connectionLog): void
    {
        // Bağlantı sonlandırıldıysa
        if ($connectionLog->isDirty('disconnected_at') && $connectionLog->disconnected_at) {
            // Bağlantı sayısını azalt
            Cache::decrement("playlist_connections:{$connectionLog->playlist_id}");

            // Cache'den bağlantı bilgisini sil
            Cache::forget("playlist_connection:{$connectionLog->playlist_id}:{$connectionLog->ip_address}");
        }
    }
}
