<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersJsonResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAll(UserRequest $request): JsonResponse
    {
        return $this->userService->getAllWithPagination($request->get('count'));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->userService->register(
            $request->get('name'),
            $request->get('email'),
            $request->get('phone'),
            $request->get('position_id'),
            $request->file('photo')
        );
    }
}
