<?php

use App\Http\Controllers\Api\GetController;
use App\Http\Controllers\Api\XtreamController;
use Illuminate\Support\Facades\Route;

// get.php compatibility
Route::get('/get.php', [GetController::class, 'index']);

// Xtream API
Route::post('/player_api.php', [XtreamController::class, 'authenticate']);
Route::get('/player_api.php', [XtreamController::class, 'authenticate']);

Route::middleware('xtream')->group(function () {
    // Live TV
    Route::get('/player_api.php/live', [XtreamController::class, 'getLiveCategories']);
    Route::get('/player_api.php/live_streams', [XtreamController::class, 'getLiveStreams']);

    // VOD
    Route::get('/player_api.php/vod', [XtreamController::class, 'getVodCategories']);
    Route::get('/player_api.php/vod_streams', [XtreamController::class, 'getVodStreams']);

    // Series
    Route::get('/player_api.php/series', [XtreamController::class, 'getSeriesCategories']);
    Route::get('/player_api.php/series_streams', [XtreamController::class, 'getSeries']);
    Route::get('/player_api.php/series/{id}', [XtreamController::class, 'getSeriesInfo']);

    // Stream URLs
    Route::get('/live/{username}/{password}/{id}.{output}', [StreamController::class, 'live']);
    Route::get('/movie/{username}/{password}/{id}.{output}', [StreamController::class, 'movie']);
    Route::get('/series/{username}/{password}/{id}.{output}', [StreamController::class, 'series']);
});