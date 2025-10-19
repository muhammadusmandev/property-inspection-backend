<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Forget cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = config('rolespermissions.roles');
        $permissions = config('rolespermissions.permissions');
        $rolePermissions = config('rolespermissions.role_permissions');

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

         foreach ($rolePermissions as $role => $permissionKeys) {
            $roleModel = Role::firstOrCreate(['name' => $role]);
            $roleModel->syncPermissions($permissionKeys);
        }
    }
}
 