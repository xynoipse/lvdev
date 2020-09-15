<?php

namespace App\Domains\Access\Services;

use App\Domains\Access\Models\Permission;
use Exception;

class PermissionService
{
    /**
     * @param  $request
     * 
     * @return Permission  $permission
     */
    public function list($request)
    {
        $search = trim($request->search);

        $permissions = Permission::query();

        if (!empty($search)) $permissions->search($search);

        return $permissions->paginate();
    }

    /**
     * @param  array  $data
     * 
     * @return Permission  $permission
     * @throws Exception
     */
    public function store(array $data = [])
    {
        $permission = Permission::create([
            'name' => $data['name'],
        ]);

        if ($permission) return $permission;
        throw new Exception('There was a problem creating this permission. Please try again.');
    }

    /**
     * @param  Permission   $permission
     * @param  array  $data
     * 
     * @return Permission  $permission
     * @throws Exception
     */
    public function update(Permission $permission, array $data = [])
    {
        $permission = tap($permission)->update([
            'name' => $data['name']
        ]);

        if ($permission) return $permission;
        throw new Exception('There was a problem updating this permission. Please try again.');
    }

    /**
     * @param  Permission  $permission
     *
     * @return Permission  $permission
     * @throws Exception
     */
    public function delete(Permission $permission)
    {
        if ($permission->delete()) return $permission;
        throw new Exception('There was a problem deleting this permission. Please try again.');
    }

    /**
     * @param  array  $data
     *
     * @return bool  true
     * @throws Exception
     */
    public function destroy(array $data = [])
    {
        if (Permission::destroy($data['ids'])) return true;
        throw new Exception('There was a problem deleting permissions. Please try again.');
    }
}
