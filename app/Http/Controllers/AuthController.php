<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatorUser;
use App\Traits\JwtTrait;
use App\Traits\ResponseTrait;


class AuthController extends Controller
{
    use JwtTrait, ResponseTrait;

    public function getToken()
    {
        $authenticatorUser = AuthenticatorUser::first();
        $token = auth()->attempt([
            'name' => $authenticatorUser->name,
            'password' => env('AUTHENTICATOR_USER_PASSWORD', 'qwerty')
        ]);
        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }
}
