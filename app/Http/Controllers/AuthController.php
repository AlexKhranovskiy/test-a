<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersJsonResource;
use App\Models\AuthenticatorUser;
use App\Models\User;
use App\Traits\JwtTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function getAll(User $user, UserRequest $request)
    {
        $count = $request->count ?? env('DEFAULT_PAGINATION_VALUE', 6);

        $result = [];
        $paginatedUsers = $user->paginate($count);

        if ($paginatedUsers->currentPage() > $paginatedUsers->lastPage()) {
            return $this->responseWithError('Page not found', 404);
        }

        $paginatedUsers->setPageName('page');
        $paginatedUsers->appends('count', $count);

        foreach ($paginatedUsers as $paginatedUser) {
            $result[] = new UsersJsonResource($paginatedUser);
        }

        return $this->responseWithSuccess([
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

    public function addUser(Request $request, User $user)
    {
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $positionId = $request->position_id;
        $photo = $request->file('photo');

        $fileName = Storage::disk('public_uploads')->put('images/users', $photo);

        if (!$fileName) {
            return $this->responseWithError('Error file uploading. File have not been saved', 500);
        }

        $user->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'position_id' => $positionId,
            'photo' => $fileName
        ]);

        return $this->responseWithSuccess([
            'message' => 'User added',
            'file name' => $fileName
        ]);
    }
}
