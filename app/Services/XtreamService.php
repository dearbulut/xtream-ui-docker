<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XtreamService
{
    protected $settingService;
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
        $this->baseUrl = $settingService->get("xtream_api_url");
        $this->username = $settingService->get("xtream_username");
        $this->password = $settingService->get("xtream_password");
    }

    public function authenticate()
    {
        try {
            $response = Http::post($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
            ]);

            if (!$response->successful()) {
                throw new \Exception("Authentication failed: " . $response->status());
            }

            $data = $response->json();
            if (!isset($data["user_info"]["auth"]) || !$data["user_info"]["auth"]) {
                throw new \Exception("Invalid credentials");
            }

            return $data;
        } catch (\Exception $e) {
            Log::error("Xtream authentication failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function syncCategories()
    {
        try {
            // Live TV kategorileri
            $liveCategories = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_live_categories",
            ])->json();

            foreach ($liveCategories as $cat) {
                Category::updateOrCreate(
                    ["id" => $cat["category_id"]],
                    [
                        "name" => $cat["category_name"],
                        "type" => "channel",
                    ]
                );
            }

            // Film kategorileri
            $movieCategories = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_vod_categories",
            ])->json();

            foreach ($movieCategories as $cat) {
                Category::updateOrCreate(
                    ["id" => $cat["category_id"]],
                    [
                        "name" => $cat["category_name"],
                        "type" => "movie",
                    ]
                );
            }

            // Dizi kategorileri
            $seriesCategories = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_series_categories",
            ])->json();

            foreach ($seriesCategories as $cat) {
                Category::updateOrCreate(
                    ["id" => $cat["category_id"]],
                    [
                        "name" => $cat["category_name"],
                        "type" => "series",
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error("Category sync failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function syncChannels()
    {
        try {
            $streams = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_live_streams",
            ])->json();

            foreach ($streams as $stream) {
                Channel::updateOrCreate(
                    ["id" => $stream["stream_id"]],
                    [
                        "name" => $stream["name"],
                        "stream_url" => $stream["stream_url"] ?? $this->buildStreamUrl($stream["stream_id"], "live"),
                        "logo" => $stream["stream_icon"],
                        "category_id" => $stream["category_id"],
                        "stream_type" => "live",
                        "epg_channel_id" => $stream["epg_channel_id"] ?? null,
                        "is_active" => true,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error("Channel sync failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function syncMovies()
    {
        try {
            $movies = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_vod_streams",
            ])->json();

            foreach ($movies as $movie) {
                Movie::updateOrCreate(
                    ["id" => $movie["stream_id"]],
                    [
                        "name" => $movie["name"],
                        "stream_url" => $movie["stream_url"] ?? $this->buildStreamUrl($movie["stream_id"], "movie"),
                        "logo" => $movie["stream_icon"],
                        "category_id" => $movie["category_id"],
                        "stream_type" => "movie",
                        "description" => $movie["plot"] ?? null,
                        "duration" => $movie["duration"] ?? null,
                        "release_date" => $movie["releaseDate"] ?? null,
                        "director" => $movie["director"] ?? null,
                        "cast" => $movie["cast"] ?? null,
                        "genre" => $movie["genre"] ?? null,
                        "rating" => $movie["rating"] ?? null,
                        "poster" => $movie["cover"] ?? null,
                        "backdrop" => $movie["backdrop_path"][0] ?? null,
                        "trailer_url" => $movie["youtube_trailer"] ?? null,
                        "is_active" => true,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error("Movie sync failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function syncSeries()
    {
        try {
            $allSeries = Http::get($this->baseUrl . "/player_api.php", [
                "username" => $this->username,
                "password" => $this->password,
                "action" => "get_series",
            ])->json();

            foreach ($allSeries as $series) {
                // Dizi detaylarını al
                $seriesInfo = Http::get($this->baseUrl . "/player_api.php", [
                    "username" => $this->username,
                    "password" => $this->password,
                    "action" => "get_series_info",
                    "series_id" => $series["series_id"],
                ])->json();

                $newSeries = Series::updateOrCreate(
                    ["id" => $series["series_id"]],
                    [
                        "name" => $series["name"],
                        "logo" => $series["cover"],
                        "category_id" => $series["category_id"],
                        "stream_type" => "series",
                        "description" => $series["plot"] ?? null,
                        "release_date" => $series["releaseDate"] ?? null,
                        "director" => $series["director"] ?? null,
                        "cast" => $series["cast"] ?? null,
                        "genre" => $series["genre"] ?? null,
                        "rating" => $series["rating"] ?? null,
                        "poster" => $series["cover"] ?? null,
                        "backdrop" => $series["backdrop_path"][0] ?? null,
                        "trailer_url" => $series["youtube_trailer"] ?? null,
                        "is_active" => true,
                    ]
                );

                // Sezonları ve bölümleri ekle
                foreach ($seriesInfo["seasons"] as $seasonData) {
                    $season = Season::updateOrCreate(
                        [
                            "series_id" => $newSeries->id,
                            "season_number" => $seasonData["season_number"],
                        ],
                        [
                            "name" => "Season " . $seasonData["season_number"],
                            "description" => null,
                            "poster" => null,
                        ]
                    );

                    foreach ($seasonData["episodes"] as $episodeData) {
                        Episode::updateOrCreate(
                            [
                                "season_id" => $season->id,
                                "episode_number" => $episodeData["episode_num"],
                            ],
                            [
                                "name" => $episodeData["title"],
                                "stream_url" => $episodeData["stream_url"] ?? $this->buildStreamUrl($episodeData["id"], "series"),
                                "description" => $episodeData["info"]["plot"] ?? null,
                                "duration" => $episodeData["info"]["duration"] ?? null,
                                "air_date" => $episodeData["info"]["releasedate"] ?? null,
                                "poster" => $episodeData["info"]["movie_image"] ?? null,
                            ]
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Series sync failed: " . $e->getMessage());
            throw $e;
        }
    }

    protected function buildStreamUrl($streamId, $type)
    {
        $extension = $type === "live" ? "ts" : "mp4";
        return "{$this->baseUrl}/live/{$this->username}/{$this->password}/{$streamId}.{$extension}";
    }
}
