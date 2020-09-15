<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\User;

use App\Domains\Access\Http\Requests\Admin\User\UpdateUserPermissionRequest;
use App\Domains\Access\Http\Requests\Admin\User\UserRequest;
use App\Domains\Access\Http\Resources\Admin\UserResource;
use App\Domains\Access\Models\User;
use App\Domains\Access\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPermissionController extends Controller
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
     * @param  UserRequest  $request
     * @param  User  $user
     * @return JsonResource
     */
    public function show(UserRequest $request, User $user)
    {
        $permissions = $this->userService->getPermissions($user);
        return new JsonResource($permissions);
    }

    /**
     * @param  UpdateUserPermissionRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserPermissionRequest $request, User $user)
    {
        $this->userService->updatePermissions($user, $request->validated());
        return new UserResource($user);
    }
}
