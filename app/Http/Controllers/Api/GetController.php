<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class GetController extends Controller
{
    protected $supportedOutputs = [
        'ts', 'mpegts', 'm3u8', 'hls', 'rtmp'
    ];

    protected $supportedTypes = [
        'm3u', 'm3u_plus', 'enigma2', 'enigma2_plus', 'simple'
    ];

    public function index(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $type = $request->input('type', 'm3u_plus');
        $output = $request->input('output', 'ts');

        if (!in_array($output, $this->supportedOutputs)) {
            return response()->json(['error' => 'Unsupported output format']);
        }

        if (!in_array($type, $this->supportedTypes)) {
            return response()->json(['error' => 'Unsupported playlist type']);
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

        return match ($type) {
            'm3u', 'm3u_plus' => $this->generateM3U($playlist, $output, $type === 'm3u_plus'),
            'enigma2', 'enigma2_plus' => $this->generateEnigma2($playlist, $output, $type === 'enigma2_plus'),
            'simple' => $this->generateSimple($playlist, $output),
            default => response()->json(['error' => 'Invalid type'])
        };
    }

    protected function generateM3U(Playlist $playlist, string $output, bool $extended = true)
    {
        $content = "#EXTM3U\n";

        foreach ($playlist->bouquets as $bouquet) {
            foreach ($bouquet->channels->where('is_active', true) as $channel) {
                if ($extended) {
                    $content .= sprintf(
                        '#EXTINF:-1 tvg-id="%s" tvg-name="%s" tvg-logo="%s" group-title="%s",%s',
                        $channel->epg_channel_id ?? '',
                        $channel->name,
                        $channel->logo ?? '',
                        $channel->category->name ?? '',
                        $channel->name
                    );
                } else {
                    $content .= "#EXTINF:-1," . $channel->name;
                }
                $content .= "\n" . $this->getStreamUrl($channel, $playlist, $output) . "\n";
            }
        }

        return response($content)
            ->header('Content-Type', 'application/x-mpegurl')
            ->header('Content-Disposition', 'attachment; filename="playlist.m3u"');
    }

    protected function generateEnigma2(Playlist $playlist, string $output, bool $extended = true)
    {
        $content = "#NAME {$playlist->name}\n";

        foreach ($playlist->bouquets as $bouquet) {
            foreach ($bouquet->channels->where('is_active', true) as $channel) {
                $streamUrl = $this->getStreamUrl($channel, $playlist, $output);
                if ($extended) {
                    $content .= "#SERVICE 4097:0:1:0:0:0:0:0:0:0:{$streamUrl}:{$channel->name}\n";
                    $content .= "#DESCRIPTION {$channel->name}\n";
                } else {
                    $content .= "#SERVICE 1:0:1:0:0:0:0:0:0:0:{$streamUrl}:{$channel->name}\n";
                }
            }
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="userbouquet.playlist.tv"');
    }

    protected function generateSimple(Playlist $playlist, string $output)
    {
        $channels = [];

        foreach ($playlist->bouquets as $bouquet) {
            foreach ($bouquet->channels->where('is_active', true) as $channel) {
                $channels[] = [
                    'name' => $channel->name,
                    'stream_url' => $this->getStreamUrl($channel, $playlist, $output),
                    'category' => $channel->category->name,
                    'logo' => $channel->logo,
                    'epg_id' => $channel->epg_channel_id,
                ];
            }
        }

        return response()->json($channels);
    }

    protected function getStreamUrl($channel, $playlist, $output)
    {
        $baseUrl = config('app.url');
        $port = config('app.port', 8080);

        return "{$baseUrl}:{$port}/{$playlist->username}/{$playlist->password}/{$channel->id}";
    }
}