<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Closure;

class JWTMiddleware
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        try {
            $this->auth = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (Exception $e) {
            if(is_a($e, TokenExpiredException::class)){
                return $this->responseWithError('The token expired.', 401);
            } else {
                return $this->responseWithError('Unauthorized', 401);
            }
        }
    }
}
