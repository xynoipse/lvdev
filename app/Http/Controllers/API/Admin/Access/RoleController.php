<?php

namespace App\Http\Controllers\API\Admin\Access;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Access\PermissionResource;
use App\Http\Resources\Admin\Access\RoleResource;
use App\Models\Access\Role\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin:super')->except(
            'index',
            'show',
            'permissions',
            'updatePermissions'
        );
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Admin\Access\RoleResource
     */
    public function index(Request $request)
    {
        $search = trim($request->search);

        $roles = Role::where('name', '!=', 'superadmin');

        if (!empty($search)) {
            $roles->where('name', 'LIKE', "%$search%");
        }

        return RoleResource::collection($roles->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Admin\Access\RoleResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create([
            'name' => $request['name'],
        ]);

        $role->syncPermissions($request['permissions']);

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Access\Role\Role  $role
     * @return \App\Http\Resources\Admin\Access\RoleResource
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Access\Role\Role  $role
     * @return \App\Http\Resources\Admin\Access\RoleResource
     */
    public function update(Request $request, Role $role)
    {
        if ($role->isAdmin()) return response()->json(['message' => 'Permission denied'], 403);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role)]
        ]);

        $role->update([
            'name' => $request['name']
        ]);

        $this->updatePermissions($request, $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Access\Role\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->isAdmin()) return response()->json(['message' => 'Permission denied'], 403);

        $role->delete();

        return response()->noContent();
    }

    /**
     * Get permissions from role
     *
     * @param  \App\Models\Access\Role\Role $role
     * @return \App\Http\Resources\Admin\Access\PermissionResource
     */
    public function permissions(Role $role)
    {
        return PermissionResource::collection($role->permissions);
    }

    /**
     * Update role permissions
     *
     * @param  \App\Models\Access\Role\Role  $role
     * @return \App\Http\Resources\Admin\Access\RoleResource
     */
    public function updatePermissions(Request $request, Role $role)
    {
        if ($role->isAdmin()) return response()->json(['message' => 'Permission denied'], 403);

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->syncPermissions($request['permissions']);

        return new RoleResource($role);
    }
}
