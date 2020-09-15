<?php

namespace App\Domains\Access\Http\Controllers\API\Admin\Permission;

use App\Domains\Access\Http\Requests\Admin\Permission\DestroyPermissionRequest;
use App\Domains\Access\Http\Requests\Admin\Permission\MassDestroyPermissionRequest;
use App\Domains\Access\Http\Requests\Admin\Permission\PermissionRequest;
use App\Domains\Access\Http\Requests\Admin\Permission\StorePermissionRequest;
use App\Domains\Access\Http\Requests\Admin\Permission\UpdatePermissionRequest;
use App\Domains\Access\Http\Resources\Admin\PermissionResource;
use App\Domains\Access\Models\Permission;
use App\Domains\Access\Services\PermissionService;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @param  PermissionService  $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param  PermissionRequest  $request
     * @return PermissionResource
     */
    public function index(PermissionRequest $request)
    {
        $permissions = $this->permissionService->list($request);
        return PermissionResource::collection($permissions);
    }

    /**
     * @param  StorePermissionRequest  $request
     * @return PermissionResource
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionService->store($request->validated());
        return new PermissionResource($permission);
    }

    /**
     * @param  PermissionRequest  $request
     * @param  Permission  $permission
     * @return PermissionResource
     */
    public function show(PermissionRequest $request, Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * @param  UpdatePermissionRequest  $request
     * @param  Permission  $permission
     * @return PermissionResource
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = $this->permissionService->update($permission, $request->validated());
        return new PermissionResource($permission);
    }

    /**
     * @param  DestroyPermissionRequest  $request
     * @param  Permission  $permission
     * @return PermissionResource
     */
    public function destroy(DestroyPermissionRequest $request, Permission $permission)
    {
        $this->permissionService->delete($permission);
        return new PermissionResource($permission);
    }

    /**
     * @param  MassDestroyPermissionRequest  $request
     * @return Response
     */
    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        $this->permissionService->destroy($request->validated());
        return response()->noContent();
    }
}
