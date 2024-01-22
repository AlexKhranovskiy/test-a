<?php

namespace App\Traits;

use App\Models\AuthenticatorUser;
use Tymon\JWTAuth\Facades\JWTAuth;

trait JwtTrait
{
    public function generateTokenWithClaims()
    {
        $authenticatorUser = AuthenticatorUser::first();
        $claims = [
            'iss' => $authenticatorUser->name,
            'jti' => $authenticatorUser->password
        ];
        //var_dump($claims);
//        $customClaims = [
//            'iss' => 'user',
//            'jti' => '123456'
//        ];
        //$microservice = new AuthenticatorUser();
        var_dump(JWTAuth::parseToken()->getPayload());
        return JWTAuth::customClaims($claims)->fromSubject($authenticatorUser);
    }
}
