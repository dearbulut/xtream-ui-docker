<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => [
                'site_title' => $this->settingService->get('site_title'),
                'site_logo' => $this->settingService->get('site_logo'),
                'site_favicon' => $this->settingService->get('site_favicon'),
                'site_theme' => $this->settingService->get('site_theme'),
                'xtream_api_url' => $this->settingService->get('xtream_api_url'),
                'xtream_username' => $this->settingService->get('xtream_username'),
                'xtream_password' => $this->settingService->get('xtream_password'),
                'epg_url' => $this->settingService->get('epg_url'),
                'epg_update_interval' => $this->settingService->get('epg_update_interval'),
                'api_token' => $this->settingService->get('api_token'),
                'allowed_ips' => $this->settingService->get('allowed_ips'),
                'block_vpn' => $this->settingService->get('block_vpn'),
                'max_connections' => $this->settingService->get('max_connections'),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_logo' => 'nullable|url',
            'site_favicon' => 'nullable|url',
            'site_theme' => 'required|in:light,dark',
            'xtream_api_url' => 'required|url',
            'xtream_username' => 'required|string',
            'xtream_password' => 'required|string',
            'epg_url' => 'nullable|url',
            'epg_update_interval' => 'required|integer|min:300',
            'api_token' => 'nullable|string',
            'allowed_ips' => 'required|string',
            'block_vpn' => 'boolean',
            'max_connections' => 'required|integer|min:1',
        ]);

        foreach ($validated as $key => $value) {
            $this->settingService->set($key, $value);
        }

        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }
}
