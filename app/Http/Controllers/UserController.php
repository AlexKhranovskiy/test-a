<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /** Calls service's method and gets all users.
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function getAll(UserRequest $request): JsonResponse
    {
        return $this->userService->getAllWithPagination($request->get('count'));
    }

    /** Calls service's method and registers user.
     * @param RegisterRequest $request
     * @return JsonResponse
     */
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

    /** Calls service's method and gets user by id.
     * @param mixed $id
     * @return JsonResponse
     */
    public function getById(mixed $id): JsonResponse
    {
        return $this->userService->getById($id);
    }
}
