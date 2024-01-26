<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    /** Calls service's method and gets token.
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function getToken(AuthService $authService): JsonResponse
    {
        return $authService->getToken();
    }
}
