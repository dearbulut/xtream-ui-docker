<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
        'is_system',
        'sort_order',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_system' => 'boolean',
    ];

    protected static $cache = [];

    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
                return json_decode($value, true);
            case 'array':
                return explode(',', $value);
            default:
                return $value;
        }
    }

    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case 'json':
                $this->attributes['value'] = json_encode($value);
                break;
            case 'array':
                $this->attributes['value'] = is_array($value) ? implode(',', $value) : $value;
                break;
            default:
                $this->attributes['value'] = $value;
        }
    }

    public static function get($key, $default = null)
    {
        if (isset(static::$cache[$key])) {
            return static::$cache[$key];
        }

        $value = Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });

        static::$cache[$key] = $value;
        return $value;
    }

    public static function set($key, $value, $type = 'string')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );

        Cache::forget("setting.{$key}");
        unset(static::$cache[$key]);

        return $setting;
    }

    public static function remove($key)
    {
        static::where('key', $key)->delete();
        Cache::forget("setting.{$key}");
        unset(static::$cache[$key]);
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->get()
            ->pluck('value', 'key');
    }

    public static function setGroup($group, array $settings)
    {
        foreach ($settings as $key => $value) {
            static::set($key, $value);
        }
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('key');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            unset(static::$cache[$setting->key]);
        });

        static::deleted(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            unset(static::$cache[$setting->key]);
        });
    }
}
