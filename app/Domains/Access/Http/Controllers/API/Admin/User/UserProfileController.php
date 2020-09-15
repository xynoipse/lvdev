<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\User;

use App\Domains\Access\Http\Requests\Admin\User\UpdateUserProfileRequest;
use App\Domains\Access\Http\Resources\Admin\UserResource;
use App\Domains\Access\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
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
     * @param  UpdateUserProfileRequest  $request
     * @return UserResource
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = $this->userService->updateProfile($request->user(), $request->validated());
        return new UserResource($user);
    }
}
