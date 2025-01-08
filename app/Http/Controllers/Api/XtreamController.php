<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class XtreamController extends Controller
{
    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $playlist = Playlist::where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$playlist) {
            return response()->json([
                'user_info' => [],
                'server_info' => [],
                'error' => 'Invalid credentials',
                'error_code' => 1
            ]);
        }

        return response()->json([
            'user_info' => [
                'username' => $playlist->username,
                'password' => $playlist->password,
                'status' => $playlist->is_active ? 'Active' : 'Disabled',
                'exp_date' => $playlist->expires_at?->timestamp ?? null,
                'is_trial' => $playlist->is_trial,
                'active_cons' => $playlist->active_connections,
                'created_at' => $playlist->created_at->timestamp,
                'max_connections' => $playlist->max_connections,
                'allowed_output_formats' => ['m3u8', 'ts', 'rtmp']
            ],
            'server_info' => [
                'url' => config('app.url'),
                'port' => config('app.port', 8080),
                'https_port' => config('app.https_port', 443),
                'server_protocol' => request()->secure() ? 'https' : 'http',
                'rtmp_port' => config('app.rtmp_port', 25462),
                'timezone' => config('app.timezone'),
                'timestamp_now' => now()->timestamp,
                'time_now' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    }

    public function getLiveCategories(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $categories = $playlist->bouquets()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->flatten()
            ->unique('id')
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'parent_id' => 0
                ];
            });

        return response()->json($categories);
    }

    public function getLiveStreams(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $category_id = $request->input('category_id');

        $channels = $playlist->bouquets()
            ->with(['channels' => function ($query) use ($category_id) {
                if ($category_id) {
                    $query->where('category_id', $category_id);
                }
            }])
            ->get()
            ->pluck('channels')
            ->flatten()
            ->unique('id')
            ->map(function ($channel) {
                return [
                    'num' => $channel->number,
                    'name' => $channel->name,
                    'stream_type' => 'live',
                    'stream_id' => $channel->id,
                    'stream_icon' => $channel->logo,
                    'epg_channel_id' => $channel->epg_channel_id,
                    'added' => $channel->created_at->timestamp,
                    'category_id' => $channel->category_id,
                    'custom_sid' => '',
                    'tv_archive' => 0,
                    'direct_source' => $channel->source,
                    'tv_archive_duration' => 0
                ];
            });

        return response()->json($channels);
    }

    public function getVodCategories(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $categories = $playlist->bouquets()
            ->whereType('movie')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->flatten()
            ->unique('id')
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'parent_id' => 0
                ];
            });

        return response()->json($categories);
    }

    public function getVodStreams(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $category_id = $request->input('category_id');

        $movies = $playlist->bouquets()
            ->whereType('movie')
            ->with(['movies' => function ($query) use ($category_id) {
                if ($category_id) {
                    $query->where('category_id', $category_id);
                }
            }])
            ->get()
            ->pluck('movies')
            ->flatten()
            ->unique('id')
            ->map(function ($movie) {
                return [
                    'num' => $movie->number,
                    'name' => $movie->name,
                    'stream_type' => 'movie',
                    'stream_id' => $movie->id,
                    'stream_icon' => $movie->poster,
                    'rating' => $movie->rating,
                    'rating_5based' => $movie->rating / 2,
                    'added' => $movie->created_at->timestamp,
                    'category_id' => $movie->category_id,
                    'container_extension' => pathinfo($movie->source, PATHINFO_EXTENSION),
                    'custom_sid' => '',
                    'direct_source' => $movie->source
                ];
            });

        return response()->json($movies);
    }

    public function getSeriesCategories(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $categories = $playlist->bouquets()
            ->whereType('series')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->flatten()
            ->unique('id')
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'parent_id' => 0
                ];
            });

        return response()->json($categories);
    }

    public function getSeries(Request $request)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $category_id = $request->input('category_id');

        $series = $playlist->bouquets()
            ->whereType('series')
            ->with(['series' => function ($query) use ($category_id) {
                if ($category_id) {
                    $query->where('category_id', $category_id);
                }
            }])
            ->get()
            ->pluck('series')
            ->flatten()
            ->unique('id')
            ->map(function ($series) {
                return [
                    'num' => $series->number,
                    'name' => $series->name,
                    'series_id' => $series->id,
                    'cover' => $series->poster,
                    'plot' => $series->description,
                    'cast' => $series->cast,
                    'director' => $series->director,
                    'genre' => $series->genre,
                    'releaseDate' => $series->release_date,
                    'last_modified' => $series->updated_at->timestamp,
                    'rating' => $series->rating,
                    'rating_5based' => $series->rating / 2,
                    'backdrop_path' => $series->backdrop,
                    'youtube_trailer' => $series->trailer,
                    'episode_run_time' => $series->episode_run_time,
                    'category_id' => $series->category_id
                ];
            });

        return response()->json($series);
    }

    public function getSeriesInfo(Request $request, $series_id)
    {
        $playlist = $this->getPlaylist($request);

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        $series = $playlist->bouquets()
            ->whereType('series')
            ->with(['series' => function ($query) use ($series_id) {
                $query->where('id', $series_id)->with('seasons.episodes');
            }])
            ->get()
            ->pluck('series')
            ->flatten()
            ->first();

        if (!$series) {
            return response()->json(['error' => 'Series not found']);
        }

        $episodes = [];
        foreach ($series->seasons as $season) {
            $episodes[$season->number] = $season->episodes->map(function ($episode) {
                return [
                    'id' => $episode->id,
                    'episode_num' => $episode->number,
                    'title' => $episode->name,
                    'container_extension' => pathinfo($episode->source, PATHINFO_EXTENSION),
                    'info' => [
                        'tmdb_id' => $episode->tmdb_id,
                        'releasedate' => $episode->air_date,
                        'plot' => $episode->description,
                        'duration_secs' => $episode->duration,
                        'duration' => gmdate('H:i:s', $episode->duration),
                        'video' => [
                            'width' => $episode->video_width,
                            'height' => $episode->video_height,
                            'duration' => $episode->duration
                        ],
                        'audio' => [
                            'language' => $episode->audio_language
                        ],
                        'bitrate' => $episode->bitrate,
                        'rating' => $episode->rating,
                        'season' => $season->number
                    ],
                    'custom_sid' => '',
                    'added' => $episode->created_at->timestamp,
                    'season' => $season->number,
                    'direct_source' => $episode->source
                ];
            })->toArray();
        }

        $info = [
            'name' => $series->name,
            'cover' => $series->poster,
            'plot' => $series->description,
            'cast' => $series->cast,
            'director' => $series->director,
            'genre' => $series->genre,
            'releaseDate' => $series->release_date,
            'last_modified' => $series->updated_at->timestamp,
            'rating' => $series->rating,
            'rating_5based' => $series->rating / 2,
            'backdrop_path' => $series->backdrop,
            'youtube_trailer' => $series->trailer,
            'episode_run_time' => $series->episode_run_time,
            'category_id' => $series->category_id,
            'episodes' => $episodes
        ];

        return response()->json(['episodes' => $episodes, 'info' => $info]);
    }

    protected function getPlaylist(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        return Playlist::where('username', $username)
            ->where('password', $password)
            ->first();
    }
}