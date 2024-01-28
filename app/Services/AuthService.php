<?php

namespace App\Services;

use App\Models\AuthenticatorUser;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthService
{
    use ResponseTrait;

    /** Gets the token.
     */
    public function getToken(): JsonResponse
    {
        $authenticatorUser = AuthenticatorUser::first();
        $token = auth()->attempt([
            'name' => $authenticatorUser->name,
            'password' => env('AUTHENTICATOR_USER_PASSWORD', 'qwerty')
        ]);

        return $this->responseWithSuccess([
            'token' => $token
        ]);
    }

    /** Resets current token.
     * @return void
     */
    public function resetCurrentToken(): void
    {
        try {
            auth()->logout();
        } catch (Exception $e){}
    }
}
