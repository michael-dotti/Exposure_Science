<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        Permission::create(['name'=>'management users']);
        Permission::create(['name'=>'management news']);
        Permission::create(['name'=>'management events']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create role and assign created permission
        $role = Role::create(['name'=>'researcher']);
        // TODO: create permission for researcher, if he need it

        $role = Role::create(['name'=>'admin']);
        $role->givePermissionTo(Permission::all());

    }
}
