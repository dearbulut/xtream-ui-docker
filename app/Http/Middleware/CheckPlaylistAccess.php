<?php

namespace App\Http\Middleware;

use App\Models\Playlist;
use App\Services\SettingService;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlaylistAccess
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->input("username");
        $password = $request->input("password");

        if (!$username || !$password) {
            return response()->json(["error" => "Invalid credentials"], 401);
        }

        $cacheKey = "playlist_access:{$username}:{$password}";
        $playlist = Cache::remember($cacheKey, 300, function () use ($username, $password) {
            return Playlist::whereHas("user", function ($query) use ($username, $password) {
                $query->where("username", $username)
                    ->where("password", $password);
            })
            ->where("is_active", true)
            ->where(function ($query) {
                $query->whereNull("expires_at")
                    ->orWhere("expires_at", ">", now());
            })
            ->first();
        });

        if (!$playlist) {
            return response()->json(["error" => "Invalid credentials"], 401);
        }

        // IP kontrolü
        $allowedIps = $playlist->allowed_ips;
        if ($allowedIps && $allowedIps !== "*") {
            $clientIp = $request->ip();
            $allowedIpList = array_map("trim", explode(",", $allowedIps));
            if (!in_array($clientIp, $allowedIpList)) {
                return response()->json(["error" => "IP not allowed"], 403);
            }
        }

        // VPN kontrolü
        if ($this->settingService->get("block_vpn", false)) {
            $isVpn = $this->checkVpn($request->ip());
            if ($isVpn) {
                return response()->json(["error" => "VPN connections are not allowed"], 403);
            }
        }

        // Bağlantı sayısı kontrolü
        $maxConnections = $playlist->max_connections;
        $currentConnections = Cache::get("playlist_connections:{$playlist->id}", 0);

        if ($currentConnections >= $maxConnections) {
            return response()->json(["error" => "Maximum connections reached"], 429);
        }

        // Bağlantı sayısını artır
        Cache::increment("playlist_connections:{$playlist->id}");
        Cache::put("playlist_connection:{$playlist->id}:{$request->ip()}", true, 300);

        $request->playlist = $playlist;
        return $next($request);
    }

    protected function checkVpn($ip)
    {
        try {
            $response = Http::get("https://vpnapi.io/api/{$ip}?key=" . config("services.vpnapi.key"));
            if ($response->successful()) {
                $data = $response->json();
                return $data["security"]["vpn"] || $data["security"]["proxy"] || $data["security"]["tor"];
            }
        } catch (\Exception $e) {
            \Log::error("VPN check failed: " . $e->getMessage());
        }

        return false;
    }
}
