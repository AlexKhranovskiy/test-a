<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Closure;

class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $this->auth = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
