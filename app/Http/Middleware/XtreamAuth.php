<?php

namespace App\Http\Middleware;

use App\Models\Playlist;
use Closure;
use Illuminate\Http\Request;

class XtreamAuth
{
    public function handle(Request $request, Closure $next)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $playlist = Playlist::where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$playlist) {
            return response()->json(['error' => 'Invalid credentials', 'error_code' => 1]);
        }

        if (!$playlist->is_active) {
            return response()->json(['error' => 'Account is disabled', 'error_code' => 2]);
        }

        if ($playlist->expires_at && $playlist->expires_at->isPast()) {
            return response()->json(['error' => 'Account has expired', 'error_code' => 3]);
        }

        $request->merge(['playlist' => $playlist]);

        return $next($request);
    }
}