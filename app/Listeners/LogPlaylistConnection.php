<?php

namespace App\Listeners;

use App\Models\ConnectionLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPlaylistConnection
{
    public function handle($event): void
    {
        if ($event instanceof Login) {
            $this->handleLogin($event);
        } elseif ($event instanceof Logout) {
            $this->handleLogout($event);
        }
    }

    protected function handleLogin($event): void
    {
        if ($event->user->playlist) {
            ConnectionLog::create([
                'playlist_id' => $event->user->playlist->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'connected_at' => now(),
            ]);
        }
    }

    protected function handleLogout($event): void
    {
        if ($event->user->playlist) {
            $log = ConnectionLog::where('playlist_id', $event->user->playlist->id)
                ->where('ip_address', request()->ip())
                ->whereNull('disconnected_at')
                ->latest()
                ->first();

            if ($log) {
                $log->update(['disconnected_at' => now()]);
            }
        }
    }
}
