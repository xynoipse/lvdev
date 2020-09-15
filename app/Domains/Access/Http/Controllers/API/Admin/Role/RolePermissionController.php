<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\Role;

use App\Domains\Access\Http\Requests\Admin\Role\RoleRequest;
use App\Domains\Access\Http\Requests\Admin\Role\UpdateRolePermissionRequest;
use App\Domains\Access\Http\Resources\Admin\PermissionResource;
use App\Domains\Access\Http\Resources\Admin\RoleResource;
use App\Domains\Access\Models\Role;
use App\Domains\Access\Services\RoleService;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
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
     * @param  Role  $role
     * @return PermissionResource
     */
    public function show(RoleRequest $request, Role $role)
    {
        return PermissionResource::collection($role->permissions);
    }

    /**
     * @param  UpdateRolePermissionRequest  $request
     * @param  Role  $role
     * @return RoleResource
     */
    public function update(UpdateRolePermissionRequest $request, Role $role)
    {
        $this->roleService->updatePermissions($role, $request->validated());
        return new RoleResource($role);
    }
}
