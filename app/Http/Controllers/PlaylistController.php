<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Channel;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Bouquet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $query = Playlist::with(['user', 'channels', 'movies', 'series', 'bouquets'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->user, function ($query, $user) {
                $query->where('user_id', $user);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            });

        return Inertia::render('Playlists/Index', [
            'playlists' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only(['search', 'user', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Playlists/Form', [
            'channels' => Channel::all(),
            'movies' => Movie::all(),
            'series' => Series::all(),
            'bouquets' => Bouquet::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
            'max_connections' => 'integer|min:1',
            'allowed_ips' => 'nullable|array',
            'notes' => 'nullable|string',
            'channels' => 'array',
            'movies' => 'array',
            'series' => 'array',
            'bouquets' => 'array',
        ]);

        $playlist = Playlist::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        if ($request->channels) {
            $playlist->channels()->attach($request->channels);
        }

        if ($request->movies) {
            $playlist->movies()->attach($request->movies);
        }

        if ($request->series) {
            $playlist->series()->attach($request->series);
        }

        if ($request->bouquets) {
            $playlist->bouquets()->attach($request->bouquets);
        }

        return redirect()->route('playlists.index')
            ->with('success', 'Playlist created successfully.');
    }

    public function edit(Playlist $playlist)
    {
        return Inertia::render('Playlists/Form', [
            'playlist' => $playlist->load(['channels', 'movies', 'series', 'bouquets']),
            'channels' => Channel::all(),
            'movies' => Movie::all(),
            'series' => Series::all(),
            'bouquets' => Bouquet::all(),
        ]);
    }

    public function update(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
            'max_connections' => 'integer|min:1',
            'allowed_ips' => 'nullable|array',
            'notes' => 'nullable|string',
            'channels' => 'array',
            'movies' => 'array',
            'series' => 'array',
            'bouquets' => 'array',
        ]);

        $playlist->update($validated);

        $playlist->channels()->sync($request->channels);
        $playlist->movies()->sync($request->movies);
        $playlist->series()->sync($request->series);
        $playlist->bouquets()->sync($request->bouquets);

        return redirect()->route('playlists.index')
            ->with('success', 'Playlist updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Playlist::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' playlists deleted successfully.';
        } else {
            Playlist::findOrFail($request->route('playlist'))->delete();
            $message = 'Playlist deleted successfully.';
        }

        return redirect()->route('playlists.index')
            ->with('success', $message);
    }

    public function show(Playlist $playlist)
    {
        return Inertia::render('Playlists/Show', [
            'playlist' => $playlist->load(['user', 'channels', 'movies', 'series', 'bouquets']),
        ]);
    }

    public function export(Playlist $playlist)
    {
        $m3u = "#EXTM3U\n";

        // Kanalları ekle
        foreach ($playlist->channels as $channel) {
            $m3u .= "#EXTINF:-1 tvg-id=\"{$channel->epg_channel_id}\" tvg-name=\"{$channel->name}\" tvg-logo=\"{$channel->logo}\" group-title=\"{$channel->category->name}\",{$channel->name}\n";
            $m3u .= "{$channel->stream_url}\n";
        }

        // Filmleri ekle
        foreach ($playlist->movies as $movie) {
            $m3u .= "#EXTINF:-1 tvg-id=\"{$movie->id}\" tvg-name=\"{$movie->name}\" tvg-logo=\"{$movie->logo}\" group-title=\"{$movie->category->name}\",{$movie->name}\n";
            $m3u .= "{$movie->stream_url}\n";
        }

        // Dizileri ekle
        foreach ($playlist->series as $series) {
            foreach ($series->seasons as $season) {
                foreach ($season->episodes as $episode) {
                    $m3u .= "#EXTINF:-1 tvg-id=\"{$series->id}_{$season->season_number}_{$episode->episode_number}\" tvg-name=\"{$series->name} S{$season->season_number}E{$episode->episode_number}\" tvg-logo=\"{$series->logo}\" group-title=\"{$series->category->name}\",{$series->name} S{$season->season_number}E{$episode->episode_number}\n";
                    $m3u .= "{$episode->stream_url}\n";
                }
            }
        }

        // Bouquet'leri ekle
        foreach ($playlist->bouquets as $bouquet) {
            foreach ($bouquet->channels as $channel) {
                $m3u .= "#EXTINF:-1 tvg-id=\"{$channel->epg_channel_id}\" tvg-name=\"{$channel->name}\" tvg-logo=\"{$channel->logo}\" group-title=\"{$bouquet->name}\",{$channel->name}\n";
                $m3u .= "{$channel->stream_url}\n";
            }

            foreach ($bouquet->movies as $movie) {
                $m3u .= "#EXTINF:-1 tvg-id=\"{$movie->id}\" tvg-name=\"{$movie->name}\" tvg-logo=\"{$movie->logo}\" group-title=\"{$bouquet->name}\",{$movie->name}\n";
                $m3u .= "{$movie->stream_url}\n";
            }

            foreach ($bouquet->series as $series) {
                foreach ($series->seasons as $season) {
                    foreach ($season->episodes as $episode) {
                        $m3u .= "#EXTINF:-1 tvg-id=\"{$series->id}_{$season->season_number}_{$episode->episode_number}\" tvg-name=\"{$series->name} S{$season->season_number}E{$episode->episode_number}\" tvg-logo=\"{$series->logo}\" group-title=\"{$bouquet->name}\",{$series->name} S{$season->season_number}E{$episode->episode_number}\n";
                        $m3u .= "{$episode->stream_url}\n";
                    }
                }
            }
        }

        return response($m3u)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $playlist->name . '.m3u"');
    }
}
