<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;

/** Class for authorization of requests */
class JWTMiddleware
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        try {
            $this->auth = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (Exception $e) {
//            if(is_a($e, TokenExpiredException::class)){
//                return $this->responseWithError('The token expired.', 401);
//            } else {
//                return $this->responseWithError('Unauthorized', 401);
//            }
            return $this->responseWithError('The token expired.', 401);
        }
    }
}
