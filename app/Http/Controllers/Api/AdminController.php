<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Playlist;
use App\Models\User;
use App\Services\XtreamService;
use App\Services\EpgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected $xtreamService;
    protected $epgService;

    public function __construct(XtreamService $xtreamService, EpgService $epgService)
    {
        $this->xtreamService = $xtreamService;
        $this->epgService = $epgService;
    }

    public function syncCategories()
    {
        try {
            $this->xtreamService->syncCategories();
            return response()->json(['message' => 'Categories synced successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncChannels()
    {
        try {
            $this->xtreamService->syncChannels();
            return response()->json(['message' => 'Channels synced successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncMovies()
    {
        try {
            $this->xtreamService->syncMovies();
            return response()->json(['message' => 'Movies synced successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncSeries()
    {
        try {
            $this->xtreamService->syncSeries();
            return response()->json(['message' => 'Series synced successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncEpg()
    {
        try {
            $this->epgService->refreshData();
            return response()->json(['message' => 'EPG data synced successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserStats()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::whereHas('playlists', function ($query) {
                $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    });
            })->count(),
            'expired_users' => User::whereHas('playlists', function ($query) {
                $query->where('expires_at', '<=', now());
            })->count(),
            'online_users' => Cache::tags(['playlist_connections'])->count(),
        ];

        return response()->json($stats);
    }

    public function getStreamStats()
    {
        $stats = [
            'channels' => [
                'total' => Channel::count(),
                'active' => Channel::where('is_active', true)->count(),
                'with_epg' => Channel::whereNotNull('epg_channel_id')->count(),
            ],
            'movies' => [
                'total' => Movie::count(),
                'active' => Movie::where('is_active', true)->count(),
            ],
            'series' => [
                'total' => Series::count(),
                'active' => Series::where('is_active', true)->count(),
                'episodes' => DB::table('episodes')->count(),
            ],
        ];

        return response()->json($stats);
    }

    public function getConnectionStats()
    {
        $stats = [
            'current_connections' => Cache::tags(['playlist_connections'])->count(),
            'connections_by_playlist' => Playlist::withCount(['connections' => function ($query) {
                $query->where('created_at', '>=', now()->subDay());
            }])->get()->pluck('connections_count', 'name'),
            'connections_by_country' => DB::table('connection_logs')
                ->select('country', DB::raw('count(*) as total'))
                ->where('created_at', '>=', now()->subDay())
                ->groupBy('country')
                ->get()
                ->pluck('total', 'country'),
        ];

        return response()->json($stats);
    }

    public function getSystemStatus()
    {
        $status = [
            'disk_usage' => [
                'total' => disk_total_space('/'),
                'free' => disk_free_space('/'),
                'used' => disk_total_space('/') - disk_free_space('/'),
            ],
            'memory_usage' => [
                'total' => memory_get_peak_usage(true),
                'used' => memory_get_usage(true),
            ],
            'cpu_load' => sys_getloadavg(),
            'uptime' => trim(file_get_contents('/proc/uptime')),
            'last_sync' => [
                'epg' => Cache::get('last_epg_sync'),
                'channels' => Cache::get('last_channels_sync'),
                'movies' => Cache::get('last_movies_sync'),
                'series' => Cache::get('last_series_sync'),
            ],
        ];

        return response()->json($status);
    }

    public function clearCache()
    {
        try {
            Cache::flush();
            return response()->json(['message' => 'Cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createBackup()
    {
        try {
            $filename = 'backup-' . now()->format('Y-m-d-His') . '.sql';
            $command = sprintf(
                'mysqldump -u%s -p%s %s > %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                storage_path('app/backups/' . $filename)
            );

            exec($command);

            return response()->json([
                'message' => 'Backup created successfully',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
