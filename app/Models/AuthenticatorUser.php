<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/** Model for generating JWT tokens */
class AuthenticatorUser extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'authenticator_users';

    protected $fillable = [
        'name',
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
