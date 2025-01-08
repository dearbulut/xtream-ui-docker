<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    return redirect()->route("login");
});

Route::middleware("guest")->group(function () {
    Route::get("login", [App\Http\Controllers\Auth\AuthenticatedSessionController::class, "create"])->name("login");
    Route::post("login", [App\Http\Controllers\Auth\AuthenticatedSessionController::class, "store"]);
});

Route::post("logout", [App\Http\Controllers\Auth\AuthenticatedSessionController::class, "destroy"])
    ->middleware("auth")
    ->name("logout");

Route::middleware(["auth"])->group(function () {
    Route::get("/dashboard", [App\Http\Controllers\DashboardController::class, "index"])->name("dashboard");
    Route::get("/profile", [App\Http\Controllers\ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [App\Http\Controllers\ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [App\Http\Controllers\ProfileController::class, "destroy"])->name("profile.destroy");

    // Channels
    Route::get("/channels", [App\Http\Controllers\ChannelController::class, "index"])->name("channels.index");
    Route::get("/channels/create", [App\Http\Controllers\ChannelController::class, "create"])->name("channels.create");
    Route::post("/channels", [App\Http\Controllers\ChannelController::class, "store"])->name("channels.store");
    Route::get("/channels/{channel}/edit", [App\Http\Controllers\ChannelController::class, "edit"])->name("channels.edit");
    Route::put("/channels/{channel}", [App\Http\Controllers\ChannelController::class, "update"])->name("channels.update");
    Route::delete("/channels/{channel}", [App\Http\Controllers\ChannelController::class, "destroy"])->name("channels.destroy");
    Route::post("/channels/refresh-epg", [App\Http\Controllers\ChannelController::class, "refreshEpg"])->name("channels.refresh-epg");

    // Categories
    Route::get("/categories", [App\Http\Controllers\CategoryController::class, "index"])->name("categories.index");
    Route::get("/categories/create", [App\Http\Controllers\CategoryController::class, "create"])->name("categories.create");
    Route::post("/categories", [App\Http\Controllers\CategoryController::class, "store"])->name("categories.store");
    Route::get("/categories/{category}/edit", [App\Http\Controllers\CategoryController::class, "edit"])->name("categories.edit");
    Route::put("/categories/{category}", [App\Http\Controllers\CategoryController::class, "update"])->name("categories.update");
    Route::delete("/categories/{category}", [App\Http\Controllers\CategoryController::class, "destroy"])->name("categories.destroy");

    // EPG
    Route::get("/epg", [App\Http\Controllers\EpgController::class, "index"])->name("epg.index");
    Route::post("/epg/refresh", [App\Http\Controllers\EpgController::class, "refresh"])->name("epg.refresh");
    Route::get("/epg/{channel}", [App\Http\Controllers\EpgController::class, "show"])->name("epg.show");
    Route::put("/epg/{channel}", [App\Http\Controllers\EpgController::class, "update"])->name("epg.update");

    // Playlists
    Route::get("/playlists", [App\Http\Controllers\PlaylistController::class, "index"])->name("playlists.index");
    Route::get("/playlists/create", [App\Http\Controllers\PlaylistController::class, "create"])->name("playlists.create");
    Route::post("/playlists", [App\Http\Controllers\PlaylistController::class, "store"])->name("playlists.store");
    Route::get("/playlists/{playlist}", [App\Http\Controllers\PlaylistController::class, "show"])->name("playlists.show");
    Route::get("/playlists/{playlist}/edit", [App\Http\Controllers\PlaylistController::class, "edit"])->name("playlists.edit");
    Route::put("/playlists/{playlist}", [App\Http\Controllers\PlaylistController::class, "update"])->name("playlists.update");
    Route::delete("/playlists/{playlist}", [App\Http\Controllers\PlaylistController::class, "destroy"])->name("playlists.destroy");
    Route::get("/playlists/{playlist}/export", [App\Http\Controllers\PlaylistController::class, "export"])->name("playlists.export");

    // Bouquets
    Route::get("/bouquets", [App\Http\Controllers\BouquetController::class, "index"])->name("bouquets.index");
    Route::get("/bouquets/create", [App\Http\Controllers\BouquetController::class, "create"])->name("bouquets.create");
    Route::post("/bouquets", [App\Http\Controllers\BouquetController::class, "store"])->name("bouquets.store");
    Route::get("/bouquets/{bouquet}", [App\Http\Controllers\BouquetController::class, "show"])->name("bouquets.show");
    Route::get("/bouquets/{bouquet}/edit", [App\Http\Controllers\BouquetController::class, "edit"])->name("bouquets.edit");
    Route::put("/bouquets/{bouquet}", [App\Http\Controllers\BouquetController::class, "update"])->name("bouquets.update");
    Route::delete("/bouquets/{bouquet}", [App\Http\Controllers\BouquetController::class, "destroy"])->name("bouquets.destroy");

    // Movies
    Route::get("/movies", [App\Http\Controllers\MovieController::class, "index"])->name("movies.index");
    Route::get("/movies/create", [App\Http\Controllers\MovieController::class, "create"])->name("movies.create");
    Route::post("/movies", [App\Http\Controllers\MovieController::class, "store"])->name("movies.store");
    Route::get("/movies/{movie}", [App\Http\Controllers\MovieController::class, "show"])->name("movies.show");
    Route::get("/movies/{movie}/edit", [App\Http\Controllers\MovieController::class, "edit"])->name("movies.edit");
    Route::put("/movies/{movie}", [App\Http\Controllers\MovieController::class, "update"])->name("movies.update");
    Route::delete("/movies/{movie}", [App\Http\Controllers\MovieController::class, "destroy"])->name("movies.destroy");


    // Series
    Route::get("/series", [App\Http\Controllers\SeriesController::class, "index"])->name("series.index");
    Route::get("/series/create", [App\Http\Controllers\SeriesController::class, "create"])->name("series.create");
    Route::post("/series", [App\Http\Controllers\SeriesController::class, "store"])->name("series.store");
    Route::get("/series/{series}", [App\Http\Controllers\SeriesController::class, "show"])->name("series.show");
    Route::get("/series/{series}/edit", [App\Http\Controllers\SeriesController::class, "edit"])->name("series.edit");
    Route::put("/series/{series}", [App\Http\Controllers\SeriesController::class, "update"])->name("series.update");
    Route::delete("/series/{series}", [App\Http\Controllers\SeriesController::class, "destroy"])->name("series.destroy");

    // Settings
    Route::get("/settings", [App\Http\Controllers\SettingsController::class, "index"])->name("settings.index");
    Route::post("/settings", [App\Http\Controllers\SettingsController::class, "update"])->name("settings.update");
});
