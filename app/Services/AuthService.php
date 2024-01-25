<?php

namespace App\Services;

use App\Models\AuthenticatorUser;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function getToken(): string
    {
        $authenticatorUser = AuthenticatorUser::first();
        $token = auth()->attempt([
            'name' => $authenticatorUser->name,
            'password' => env('AUTHENTICATOR_USER_PASSWORD', 'qwerty')
        ]);
        return $token;
    }

    public function resetCurrentToken()
    {
        try {
            auth()->logout();
            //Auth::invalidate();
        } catch (Exception $e){}
    }
}
