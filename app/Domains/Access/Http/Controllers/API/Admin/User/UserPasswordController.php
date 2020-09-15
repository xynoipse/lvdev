<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\User;

use App\Domains\Access\Http\Requests\Admin\User\UpdateUserPasswordRequest;
use App\Domains\Access\Http\Resources\Admin\UserResource;
use App\Domains\Access\Models\User;
use App\Domains\Access\Services\UserService;
use App\Http\Controllers\Controller;

class UserPasswordController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $user = $this->userService->updatePassword($user, $request->validated());
        return new UserResource($user);
    }
}
