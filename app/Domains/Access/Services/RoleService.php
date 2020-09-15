<?php

namespace App\Domains\Access\Services;

use App\Domains\Access\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleService
{
    /**
     * @param  $request
     * 
     * @return Role  $role
     */
    public function list($request)
    {
        $search = trim($request->search);

        $roles = Role::query();

        if (!empty($search)) $roles->search($search);

        return $roles->paginate();
    }

    /**
     * @param  array  $data
     * 
     * @return Role  $role
     * @throws Exception
     */
    public function store(array $data = [])
    {
        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => $data['name'],
            ]);

            $role->syncPermissions($data['permissions']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('There was a problem creating this role. Please try again.');
        }

        DB::commit();

        return $role;
    }

    /**
     * @param  Role   $role
     * @param  array  $data
     * 
     * @return Role  $role
     * @throws Exception
     */
    public function update(Role $role, array $data = [])
    {
        DB::beginTransaction();

        try {
            $role = tap($role)->update([
                'name' => $data['name']
            ]);

            $this->updatePermissions($role, $data);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('There was a problem updating this role. Please try again.');
        }

        DB::commit();

        return $role;
    }

    /**
     * @param  Role  $role
     *
     * @return Role  $role
     * @throws Exception
     */
    public function delete(Role $role)
    {
        if ($role->delete()) return $role;
        throw new Exception('There was a problem deleting this role. Please try again.');
    }

    /**
     * @param  array  $data
     *
     * @return bool  true
     * @throws Exception
     */
    public function destroy(array $data = [])
    {
        if (Role::destroy($data['ids'])) return true;
        throw new Exception('There was a problem deleting roles. Please try again.');
    }

    /**
     * @param  Role  $role
     * @param  array  $data
     * 
     * @return Role  $role
     */
    public function updatePermissions(Role $role, array $data = [])
    {
        $role->syncPermissions($data['permissions']);
        return $role;
    }
}
