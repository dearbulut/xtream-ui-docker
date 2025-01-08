<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\XtreamService;
use App\Services\EpgService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class XtreamController extends Controller
{
    protected $xtreamService;
    protected $epgService;

    public function __construct(XtreamService $xtreamService, EpgService $epgService)
    {
        $this->xtreamService = $xtreamService;
        $this->epgService = $epgService;
    }

    /**
     * Player API endpoint
     */
    public function playerApi(Request $request)
    {
        $action = $request->input('action');
        $params = $request->except(['action', 'username', 'password']);

        try {
            $data = $this->xtreamService->makeRequest($action, $params);
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Player API Error', [
                'action' => $action,
                'params' => $params,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * XML TV endpoint
     */
    public function xmltv(Request $request)
    {
        try {
            $data = $this->epgService->getEpgData();
            return response($data)->header('Content-Type', 'application/xml');
        } catch (\Exception $e) {
            Log::error('XMLTV Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Stream endpoint
     */
    public function stream(Request $request, $username, $password, $stream, $ext)
    {
        try {
            $url = $this->xtreamService->getStreamUrl($stream);
            return redirect($url);
        } catch (\Exception $e) {
            Log::error('Stream Error', [
                'stream' => $stream,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Stream not found'], 404);
        }
    }

    /**
     * Movie stream endpoint
     */
    public function movie(Request $request, $username, $password, $stream, $ext)
    {
        try {
            $url = $this->xtreamService->getStreamUrl($stream, 'movie');
            return redirect($url);
        } catch (\Exception $e) {
            Log::error('Movie Stream Error', [
                'stream' => $stream,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Stream not found'], 404);
        }
    }

    /**
     * Series stream endpoint
     */
    public function series(Request $request, $username, $password, $stream, $ext)
    {
        try {
            $url = $this->xtreamService->getStreamUrl($stream, 'series');
            return redirect($url);
        } catch (\Exception $e) {
            Log::error('Series Stream Error', [
                'stream' => $stream,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Stream not found'], 404);
        }
    }

    /**
     * Admin panel
     */
    public function panel()
    {
        $stats = [
            'categories' => count($this->xtreamService->getLiveCategories() ?? []),
            'channels' => count($this->xtreamService->getLiveStreams() ?? []),
            'movies' => count($this->xtreamService->getVodStreams() ?? []),
            'series' => count($this->xtreamService->getSeries() ?? []),
        ];

        return view('xtream.panel', compact('stats'));
    }

    /**
     * Settings page
     */
    public function settings()
    {
        $settings = config('xtream');
        return view('xtream.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'api_url' => 'required|url',
            'username' => 'required',
            'password' => 'required',
            'epg_url' => 'nullable|url',
        ]);

        try {
            // .env dosyasını güncelle
            $this->updateEnvFile([
                'XTREAM_API_URL' => $validated['api_url'],
                'XTREAM_USERNAME' => $validated['username'],
                'XTREAM_PASSWORD' => $validated['password'],
                'XTREAM_EPG_URL' => $validated['epg_url'],
            ]);

            // Önbelleği temizle
            $this->xtreamService->clearCache();
            $this->epgService->clearCache();

            return redirect()->back()->with('success', __('xtream.settings_updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('xtream.settings_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * EPG verilerini önbelleğe al
     */
    public function cacheEpg()
    {
        try {
            $data = $this->epgService->getEpgData();
            if ($data === null) {
                return redirect()->back()->with('error', __('xtream.epg_not_found'));
            }

            return redirect()->back()->with('success', __('xtream.epg_updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('xtream.epg_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Kanalları senkronize et
     */
    public function syncChannels()
    {
        try {
            // Önbelleği temizle
            $this->xtreamService->clearCache();

            // Kategorileri al
            $categories = $this->xtreamService->getLiveCategories();
            if (!$categories) {
                return redirect()->back()->with('error', __('xtream.channel_error'));
            }

            // Her kategori için kanalları al
            foreach ($categories as $category) {
                $channels = $this->xtreamService->getLiveStreams($category['category_id']);
                if (!$channels) {
                    Log::warning('Category channels not found', ['category' => $category]);
                }
            }

            return redirect()->back()->with('success', __('xtream.channels_synced'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('xtream.channel_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Önbelleği temizle
     */
    public function clearCache()
    {
        try {
            $this->xtreamService->clearCache();
            $this->epgService->clearCache();

            return redirect()->back()->with('success', __('xtream.cache_cleared'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('xtream.cache_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * .env dosyasını güncelle
     */
    protected function updateEnvFile($data)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $envContent = preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                $envContent
            );
        }

        file_put_contents($envFile, $envContent);
    }
}
