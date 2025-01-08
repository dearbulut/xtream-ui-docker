<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected $settings = [];
    protected $cacheKey = "settings";
    protected $cacheDuration = 3600; // 1 hour

    public function __construct()
    {
        // $this->loadSettings();
    }

    protected function loadSettings()
    {
        $this->settings = Cache::remember($this->cacheKey, $this->cacheDuration, function () {
            return Setting::pluck("value", "key")->toArray();
        });
    }

    public function get($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function set($key, $value)
    {
        Setting::updateOrCreate(
            ["key" => $key],
            ["value" => $value]
        );

        $this->settings[$key] = $value;
        Cache::put($this->cacheKey, $this->settings, $this->cacheDuration);
    }

    public function forget($key)
    {
        Setting::where("key", $key)->delete();
        unset($this->settings[$key]);
        Cache::put($this->cacheKey, $this->settings, $this->cacheDuration);
    }

    public function all()
    {
        return $this->settings;
    }

    public function has($key)
    {
        return isset($this->settings[$key]);
    }
}
