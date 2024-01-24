<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserByIdJsonResource;
use App\Http\Resources\UsersAllJsonResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserService
{
    use ResponseTrait;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllWithPagination(?int $count): JsonResponse
    {
        if (is_null($count)) {
            $count = env('DEFAULT_PAGINATION_VALUE', 6);
        }

        $result = [];
        $paginatedUsers = $this->user->paginate($count);

        if ($paginatedUsers->currentPage() > $paginatedUsers->lastPage()) {
            return $this->responseWithError('Page not found', 404);
        }

        $paginatedUsers->setPageName('page');
        $paginatedUsers->appends('count', $count);

        foreach ($paginatedUsers as $paginatedUser) {
            $result[] = new UsersAllJsonResource($paginatedUser);
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

    public function register(string $name, string $email, string $phone, string $positionId, UploadedFile $photo)
    {
        $fileName = Storage::disk('public_uploads')->put('images/users', $photo);

        if (!$fileName) {
            return $this->responseWithError('Error file uploading. File have not been saved', 500);
        }

        $user = User::where('phone', $phone)->orWhere('email', $email)->first();
        if (!is_null($user)) {
            return $this->responseWithError('User with this phone or email already exist', 409);
        } else {
            $newUser = $this->user->create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'position_id' => $positionId,
                'photo' => $fileName
            ]);

            $t = new TinyPngService();
            $t->fitPhoto('/var/www/html/public/' . $fileName);

            return $this->responseWithSuccess([
                'user_id' => $newUser->id,
                'message' => 'New user successfully registered'
            ]);
        }
    }

    public function getById(mixed $id): JsonResponse
    {
        $validator = Validator::make(['user_id' => $id], [
            'user_id' => 'integer',
        ], [
            'integer' => 'The :attribute must be an integer.',
        ], [
            'user_id' => 'user_id'
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(
                $this->validationErrorResponse($validator)
            );
        }

        $user = User::find($id);

        if (is_null($user)) {
            return $this->responseWithError(
                'The user with the requested identifier does not exist',
                404, [
                    'fails' => [
                        'user_id' => 'User not found'
                    ]
                ]
            );
        } else {
            return $this->responseWithSuccess([
                'user' => new UserByIdJsonResource($user)
            ]);
        }
    }
}
