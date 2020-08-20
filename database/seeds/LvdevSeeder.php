<?php

use App\Acl;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class LvdevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (Acl::roles() as $role) {
            $role = Role::findOrCreate($role);

            User::create([
                'name' => ucfirst($role->name),
                'email' => "{$role->name}@app.com",
                'password' => Hash::make('password'),
            ])->assignRole($role);
        }
    }
}
