<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class AuthenticatorUser extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'authenticator_users';
//    private mixed $key;
//
//    public function __construct($key)
//    {
//        $this->key = $key;
//    }
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
