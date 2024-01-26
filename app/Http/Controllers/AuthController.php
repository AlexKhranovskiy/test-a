<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatorUser;
use App\Services\AuthService;
use App\Traits\JwtTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    use ResponseTrait;

    /** Calls service's method, wraps response.
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function getToken(AuthService $authService): JsonResponse
    {
        return $this->responseWithSuccess([
            'token' => $authService->getToken()
        ]);
    }
}
