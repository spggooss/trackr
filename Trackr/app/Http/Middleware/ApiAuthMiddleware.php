<?php

namespace App\Http\Middleware;

use App\Models\Webshop;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = $request->header('Authorization');
        if (!$apiToken) {
            throw new AuthenticationException('Missing API token.');
        }

        $user = Webshop::where('api_token', $apiToken)->first();
        if (!$user) {
            throw new AuthenticationException('Invalid API token.');
        }

        return $next($request);
    }
}
