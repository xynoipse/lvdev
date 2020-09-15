<?php

namespace App\Domains\Access\Services;

use App\Domains\Access\Http\Resources\Admin\PermissionResource;
use App\Domains\Access\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @param  $request
     * 
     * @return User  $user
     */
    public function list($request)
    {
        $role = trim($request['role']);
        $search = trim($request['search']);

        $users = User::whereNotIn('id', [1, $request->user()->id]);

        if (!empty($role)) $users->byRole($role);
        if (!empty($search)) $users->search($search);

        return $users->paginate();
    }

    /**
     * @param  array  $data
     * 
     * @return User  $user
     * @throws Exception
     */
    public function store(array $data = [])
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->assignRole($data['role']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('There was a problem creating this user. Please try again.');
        }

        DB::commit();

        return $user;
    }

    /**
     * @param  User   $user
     * @param  array  $data
     * 
     * @return User  $user
     * @throws Exception
     */
    public function update(User $user, array $data = [])
    {
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $user->syncRoles($data['role']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('There was a problem updating this user. Please try again.');
        }

        DB::commit();

        return $user;
    }

    /**
     * @param  User  $user
     *
     * @return User  $user
     * @throws Exception
     */
    public function delete(User $user)
    {
        if ($user->delete()) return $user;
        throw new Exception('There was a problem deleting this user. Please try again.');
    }

    /**
     * @param  array  $data
     *
     * @return bool  true
     * @throws Exception
     */
    public function destroy(array $data = [])
    {
        if (User::destroy($data['ids'])) return true;
        throw new Exception('There was a problem deleting users. Please try again.');
    }

    /**
     * @param  User  $user
     *
     * @return array
     */
    public function getPermissions(User $user)
    {
        return [
            'user' => PermissionResource::collection($user->getDirectPermissions()),
            'role' => PermissionResource::collection($user->getPermissionsViaRoles()),
        ];
    }

    /**
     * @param  User  $user
     * @param  array  $data
     * 
     * @return User  $user
     */
    public function updatePermissions(User $user, array $data = [])
    {
        $user->syncPermissions($data['permissions']);
        return $user;
    }

    /**
     * @param  $user
     * @param  array  $data
     *
     * @return $user
     * @throws Exception
     */
    public function updateProfile($user, array $data = [])
    {
        $user = tap($user)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (isset($data['password'])) $this->updatePassword($user, $data);

        if ($user) return $user;
        throw new Exception('There was a problem updating user profile. Please try again.');
    }

    /**
     * @param  User $user
     * @param  array  $data
     *
     * @return $user
     * @throws Exception
     */
    public function updatePassword(User $user, array $data = [])
    {
        $user = tap($user)->update([
            'password' => $data['password'],
        ]);

        if ($user) return $user;
        throw new Exception('There was a problem updating user password. Please try again.');
    }
}
