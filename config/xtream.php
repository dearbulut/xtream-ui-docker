<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xtream API Configuration
    |--------------------------------------------------------------------------
    |
    | Xtream API bağlantı ayarları
    |
    */

    "api_url" => env("XTREAM_API_URL", ""),
    "username" => env("XTREAM_USERNAME", ""),
    "password" => env("XTREAM_PASSWORD", ""),
    "epg_url" => env("XTREAM_EPG_URL", ""),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache ayarları
    |
    */

    "cache" => [
        "ttl" => env("XTREAM_CACHE_TTL", 3600), // 1 saat
        "prefix" => env("XTREAM_CACHE_PREFIX", "xtream_"),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stream Configuration
    |--------------------------------------------------------------------------
    |
    | Yayın akışı ayarları
    |
    */

    "stream" => [
        "default_player" => env("XTREAM_DEFAULT_PLAYER", "html5"), // html5, vlc, jwplayer
        "allowed_players" => ["html5", "vlc", "jwplayer"],
        "default_output" => env("XTREAM_DEFAULT_OUTPUT", "ts"), // ts, m3u8
        "allowed_outputs" => ["ts", "m3u8"],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Güvenlik ayarları
    |
    */

    "security" => [
        "max_connections" => env("XTREAM_MAX_CONNECTIONS", 1),
        "allowed_ips" => array_filter(explode(",", env("XTREAM_ALLOWED_IPS", "*"))),
        "block_vpn" => env("XTREAM_BLOCK_VPN", false),
        "api_token" => env("XTREAM_API_TOKEN", null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Features Configuration
    |--------------------------------------------------------------------------
    |
    | Özellik ayarları
    |
    */

    "features" => [
        "enable_catchup" => env("XTREAM_ENABLE_CATCHUP", true),
        "enable_epg" => env("XTREAM_ENABLE_EPG", true),
        "enable_series" => env("XTREAM_ENABLE_SERIES", true),
        "enable_movies" => env("XTREAM_ENABLE_MOVIES", true),
        "enable_radio" => env("XTREAM_ENABLE_RADIO", false),
    ],
];
