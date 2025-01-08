<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Playlist;
use Symfony\Component\Process\Process;

class StreamService
{
    public function handleLiveStream(Channel $channel, Playlist $playlist, string $output = 'ts')
    {
        // Burada stream işlemleri yapılacak
        // Örnek olarak ffmpeg ile stream işlemi:
        
        $process = new Process([
            'ffmpeg',
            '-i', $channel->source,
            '-c:v', 'copy',
            '-c:a', 'copy',
            '-f', $output === 'ts' ? 'mpegts' : 'hls',
            '-'
        ]);

        $process->start();

        return response()->stream(
            function () use ($process) {
                while ($process->isRunning()) {
                    echo $process->getIncrementalOutput();
                    flush();
                }
            },
            200,
            [
                'Content-Type' => $output === 'ts' ? 'video/mp2t' : 'application/x-mpegURL',
            ]
        );
    }

    public function handleMovieStream(Movie $movie, Playlist $playlist, string $output = 'ts')
    {
        $process = new Process([
            'ffmpeg',
            '-i', $movie->source,
            '-c:v', 'copy',
            '-c:a', 'copy',
            '-f', $output === 'ts' ? 'mpegts' : 'hls',
            '-'
        ]);

        $process->start();

        return response()->stream(
            function () use ($process) {
                while ($process->isRunning()) {
                    echo $process->getIncrementalOutput();
                    flush();
                }
            },
            200,
            [
                'Content-Type' => $output === 'ts' ? 'video/mp2t' : 'application/x-mpegURL',
            ]
        );
    }

    public function handleEpisodeStream(Episode $episode, Playlist $playlist, string $output = 'ts')
    {
        $process = new Process([
            'ffmpeg',
            '-i', $episode->source,
            '-c:v', 'copy',
            '-c:a', 'copy',
            '-f', $output === 'ts' ? 'mpegts' : 'hls',
            '-'
        ]);

        $process->start();

        return response()->stream(
            function () use ($process) {
                while ($process->isRunning()) {
                    echo $process->getIncrementalOutput();
                    flush();
                }
            },
            200,
            [
                'Content-Type' => $output === 'ts' ? 'video/mp2t' : 'application/x-mpegURL',
            ]
        );
    }
}