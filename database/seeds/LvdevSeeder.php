<?php

use App\Acl;
use App\Domains\Access\Models\Role;
use App\Domains\Access\Models\User;
use Illuminate\Database\Seeder;
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

        // Add the master administrator, user id of 1
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@app.com',
            'password' => 'password',
            'email_verified_at' => now(),
        ])->assignRole(Role::findOrCreate(Acl::ROLE_ADMIN));

        foreach (Acl::roles() as $role) {
            $role = Role::findOrCreate($role);

            if (app()->environment(['local', 'testing'])) {
                User::create([
                    'name' => ucfirst($role->name),
                    'email' => "{$role->name}@app.com",
                    'password' => 'password',
                    'email_verified_at' => now(),
                ])->assignRole($role);
            }
        }
    }
}
