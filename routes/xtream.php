<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XtreamController;

Route::prefix("xtream")->group(function () {
    // Player API Routes
    Route::middleware(["xtream.auth"])->group(function () {
        Route::get("player_api.php", [XtreamController::class, "playerApi"]);
        Route::post("player_api.php", [XtreamController::class, "playerApi"]);
        Route::get("xmltv.php", [XtreamController::class, "xmltv"]);
        Route::get("live/{username}/{password}/{stream}.{ext}", [XtreamController::class, "stream"]);
        Route::get("movie/{username}/{password}/{stream}.{ext}", [XtreamController::class, "movie"]);
        Route::get("series/{username}/{password}/{stream}.{ext}", [XtreamController::class, "series"]);
    });

    // Panel Routes
    Route::middleware(["auth"])->group(function () {
        Route::get("panel", [XtreamController::class, "panel"])->name("xtream.panel");
        Route::get("settings", [XtreamController::class, "settings"])->name("xtream.settings");
        Route::post("settings", [XtreamController::class, "updateSettings"])->name("xtream.settings.update");
        
        // Cache Routes
        Route::post("cache/epg", [XtreamController::class, "cacheEpg"])->name("xtream.cache-epg");
        Route::post("cache/channels", [XtreamController::class, "syncChannels"])->name("xtream.sync-channels");
        Route::post("cache/clear", [XtreamController::class, "clearCache"])->name("xtream.cleanup-cache");
    });
});
