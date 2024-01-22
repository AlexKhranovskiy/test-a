<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartnerPaymentsJsonResource;
use App\Http\Resources\UsersJsonResource;
use App\Models\AuthenticatorUser;
use App\Models\PartnerAccountAuthenticatable;
use App\Models\User;
use App\Traits\JwtTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use JwtTrait;

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

    public function getAll(User $user, Request $request)
    {
        $count = $request->count ?? 6;
        $result = [];
        $paginatedUsers = $user->paginate($count);
        $paginatedUsers->setPageName('page');
        $paginatedUsers->appends('count', $count);

        foreach ($paginatedUsers as $paginatedUser) {
            $result[] = new UsersJsonResource($paginatedUser);
        }

        return response()->json([
            'success' => true,
            'page' => $paginatedUsers->currentPage(),
            'total_pages' => $paginatedUsers->lastPage(),
            'total_users' => $paginatedUsers->total(),
            'count' => $paginatedUsers->perPage(),
            'links' => [
                'next_url' => $paginatedUsers->nextPageUrl(),
                'prev_url' => $paginatedUsers->previousPageUrl()
            ],
            'users' => $result,
        ]);
    }
}
