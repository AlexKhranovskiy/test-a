<?php

namespace App\Services;

use App\Models\AuthenticatorUser;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /** Gets the token.
     * @return string
     */
    public function getToken(): string
    {
        $authenticatorUser = AuthenticatorUser::first();
        $token = auth()->attempt([
            'name' => $authenticatorUser->name,
            'password' => env('AUTHENTICATOR_USER_PASSWORD', 'qwerty')
        ]);
        return $token;
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
