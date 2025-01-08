<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Services\StreamService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    protected $supportedOutputs = [
        'ts', 'mpegts', 'm3u8', 'hls', 'rtmp'
    ];

    public function live($username, $password, $id, $output)
    {
        if (!in_array($output, $this->supportedOutputs)) {
            return response()->json(['error' => 'Unsupported output format']);
        }

        $playlist = Playlist::where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        if (!$playlist->is_active) {
            return response()->json(['error' => 'Account is disabled']);
        }

        if ($playlist->expires_at && $playlist->expires_at->isPast()) {
            return response()->json(['error' => 'Account has expired']);
        }

        $channel = Channel::whereHas('bouquets', function ($query) use ($playlist) {
            $query->whereHas('playlists', function ($query) use ($playlist) {
                $query->where('playlist_id', $playlist->id);
            });
        })->find($id);

        if (!$channel) {
            return response()->json(['error' => 'Channel not found']);
        }

        if (!$channel->is_active) {
            return response()->json(['error' => 'Channel is not active']);
        }

        return $this->streamContent($channel->source, $output);
    }

    public function movie($username, $password, $id, $output)
    {
        if (!in_array($output, $this->supportedOutputs)) {
            return response()->json(['error' => 'Unsupported output format']);
        }

        $playlist = Playlist::where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        if (!$playlist->is_active) {
            return response()->json(['error' => 'Account is disabled']);
        }

        if ($playlist->expires_at && $playlist->expires_at->isPast()) {
            return response()->json(['error' => 'Account has expired']);
        }

        $movie = Movie::whereHas('bouquets', function ($query) use ($playlist) {
            $query->whereHas('playlists', function ($query) use ($playlist) {
                $query->where('playlist_id', $playlist->id);
            });
        })->find($id);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found']);
        }

        if (!$movie->is_active) {
            return response()->json(['error' => 'Movie is not active']);
        }

        return $this->streamContent($movie->source, $output);
    }

    public function series($username, $password, $id, $output)
    {
        if (!in_array($output, $this->supportedOutputs)) {
            return response()->json(['error' => 'Unsupported output format']);
        }

        $playlist = Playlist::where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials']);
        }

        if (!$playlist->is_active) {
            return response()->json(['error' => 'Account is disabled']);
        }

        if ($playlist->expires_at && $playlist->expires_at->isPast()) {
            return response()->json(['error' => 'Account has expired']);
        }

        $episode = Episode::whereHas('season.series.bouquets', function ($query) use ($playlist) {
            $query->whereHas('playlists', function ($query) use ($playlist) {
                $query->where('playlist_id', $playlist->id);
            });
        })->find($id);

        if (!$episode) {
            return response()->json(['error' => 'Episode not found']);
        }

        if (!$episode->is_active) {
            return response()->json(['error' => 'Episode is not active']);
        }

        return $this->streamContent($episode->source, $output);
    }

    protected function streamContent($source, $output)
    {
        $streamService = app(StreamService::class);

        if ($source instanceof Channel) {
            return $streamService->handleLiveStream($source, $playlist, $output);
        }

        if ($source instanceof Movie) {
            return $streamService->handleMovieStream($source, $playlist, $output);
        }

        if ($source instanceof Episode) {
            return $streamService->handleEpisodeStream($source, $playlist, $output);
        }

        return redirect($source);
    }
}