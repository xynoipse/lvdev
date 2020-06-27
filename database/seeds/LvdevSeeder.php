<?php

use App\Models\Role;
use App\Models\User;
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

        $roles = [
            'superadmin',
            'admin',
            'user'
        ];

        foreach ($roles as $value) {
            $role = Role::create(['name' => $value]);

            User::create([
                'name' => ucfirst($value),
                'email' => $value . '@lvdev.com',
                'password' => Hash::make('password'),
            ])->assignRole($role);
        }
    }
}
