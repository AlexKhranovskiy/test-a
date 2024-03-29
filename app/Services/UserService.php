<?php

namespace App\Services;

use App\Http\Resources\UserByIdJsonResource;
use App\Http\Resources\UsersAllJsonResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/** Service for working with User */
class UserService
{
    use ResponseTrait;

    protected User $user;
    protected FileService $fileService;
    protected TinyPngService $tinyPngService;
    protected AuthService $authService;

    public function __construct(
        User $user, FileService $fileService, TinyPngService $tinyPngService, AuthService $authService
    )
    {
        $this->user = $user;
        $this->fileService = $fileService;
        $this->tinyPngService = $tinyPngService;
        $this->authService = $authService;
    }

    /** Gets all users, paginates, sorts registration_timestamp by desc.
     * @param int|null $count
     * @return JsonResponse
     */
    public function getAllWithPagination(?int $count): JsonResponse
    {
        if (is_null($count)) {
            $count = env('DEFAULT_PAGINATION_VALUE', 6);
        }

        $result = [];
        $paginatedUsers = $this->user->orderBy('registration_timestamp', 'desc')->paginate($count);

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

    /** Registers a new user, handles photo.
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $positionId
     * @param UploadedFile $photo
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $phone, string $positionId, UploadedFile $photo): JsonResponse
    {
        $fileName = Storage::disk('public_uploads')->put('images/users', $photo);

        if (!$fileName) {
            return $this->responseWithError('Error file uploading. File have not been saved', 500);
        }

        $user = $this->user->where('phone', $phone)->orWhere('email', $email)->first();

        if (!is_null($user)) {
            return $this->responseWithError('User with this phone or email already exist', 409);
        } else {
            $this->fileService->setFileDirectory(public_path() . '/images/users');
            $this->fileService->setFileName($fileName);

            if (!$this->fileService->hasJpgOrJpegExtension()) {
                $extension = $this->tinyPngService->convertToJpeg(
                    $this->fileService->getFileDirectory(), $this->fileService->getFileName()
                );
                $this->fileService->renameFileExtension($extension);
            }

            $this->tinyPngService->fitPhotoByThumbAlgorithm(
                $this->fileService->getFileDirectory(), $this->fileService->getFileName()
            );

            $newUser = $this->user->create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'position_id' => $positionId,
                'photo' => $this->fileService->getFileName()
            ]);

            $this->authService->resetCurrentToken();

            return $this->responseWithSuccess([
                'user_id' => $newUser->id,
                'message' => 'New user successfully registered'
            ]);
        }
    }

    /** Gets a user by given id.
     * @param mixed $id
     * @return JsonResponse
     */
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
                $this->validationErrorResponse($validator, code: 400)
            );
        }

        $user = User::find($id);

        if (is_null($user)) {
            return $this->responseWithError(
                'The user with the requested identifier does not exist',
                404, [
                    'fails' => [
                        'user_id' => ['User not found']
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
