<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\User;

use App\Domains\Access\Http\Requests\Admin\User\DestroyUserRequest;
use App\Domains\Access\Http\Requests\Admin\User\MassDestroyUserRequest;
use App\Domains\Access\Http\Requests\Admin\User\StoreUserRequest;
use App\Domains\Access\Http\Requests\Admin\User\UpdateUserRequest;
use App\Domains\Access\Http\Requests\Admin\User\UserRequest;
use App\Domains\Access\Http\Resources\Admin\UserResource;
use App\Domains\Access\Models\User;
use App\Domains\Access\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
     * @return UserResource
     */
    public function index(UserRequest $request)
    {
        $users = $this->userService->list($request);
        return UserResource::collection($users);
    }

    /**
     * @param  StoreUserRequest  $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request->validated());
        return new UserResource($user);
    }

    /**
     * @param  UserRequest  $request
     * @param  User  $user
     * @return Response
     */
    public function show(UserRequest $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request->validated());
        return new UserResource($user);
    }

    /**
     * @param  User  $user
     * @return UserResource
     */
    public function destroy(DestroyUserRequest $request, User $user)
    {
        $this->userService->delete($user);
        return new UserResource($user);
    }

    /**
     * @param  MassDestroyUserRequest  $request
     * @return Response
     */
    public function massDestroy(MassDestroyUserRequest $request)
    {
        $this->userService->destroy($request->validated());
        return response()->noContent();
    }
}
