<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\Role;

use App\Domains\Access\Http\Requests\Admin\Role\DestroyRoleRequest;
use App\Domains\Access\Http\Requests\Admin\Role\MassDestroyRoleRequest;
use App\Domains\Access\Http\Requests\Admin\Role\RoleRequest;
use App\Domains\Access\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Domains\Access\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Domains\Access\Http\Resources\Admin\RoleResource;
use App\Domains\Access\Models\Role;
use App\Domains\Access\Services\RoleService;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @param  RoleService  $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param  RoleRequest  $request
     * @return RoleResource
     */
    public function index(RoleRequest $request)
    {
        $roles = $this->roleService->list($request);
        return RoleResource::collection($roles);
    }

    /**
     * @param  StoreRoleRequest  $request
     * @return RoleResource
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->store($request->validated());
        return new RoleResource($role);
    }

    /**
     * @param  RoleRequest  $request
     * @param  Role  $role
     * @return RoleResource
     */
    public function show(RoleRequest $request, Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * @param  UpdateRoleRequest  $request
     * @param  Role  $role
     * @return RoleResource
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $this->roleService->update($role, $request->validated());
        return new RoleResource($role);
    }

    /**
     * @param  DestroyRoleRequest  $request
     * @param  Role  $role
     * @return Response
     */
    public function destroy(DestroyRoleRequest $request, Role $role)
    {
        $this->roleService->delete($role);
        return new RoleResource($role);
    }

    /**
     * @param  MassDestroyRoleRequest  $request
     * @return Response
     */
    public function massDestroy(MassDestroyRoleRequest $request)
    {
        $this->roleService->destroy($request->validated());
        return response()->noContent();
    }
}
