<?php

namespace App\Http\Middleware;

use App\Services\SettingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header("X-API-Token") ?? $request->input("api_token");
        $validToken = $this->settingService->get("api_token");

        if (!$token || !$validToken || $token !== $validToken) {
            return response()->json(["error" => "Invalid API token"], 401);
        }

        return $next($request);
    }
}
