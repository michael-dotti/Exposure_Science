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
        Permission::create(['name'=>'write articles']);
        Permission::create(['name'=>'edit own articles']);
        Permission::create(['name'=>'edit all articles']);
        Permission::create(['name'=>'teaching']);
        Permission::create(['name'=>'management projects']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $Researcher = Role::create(['name'=>'Researcher']);
        $Researcher->givePermissionTo('write articles'); 
        $Researcher->givePermissionTo('edit own articles');
        
        $newsManager = Role::create(['name'=>'news Manager']);
        $newsManager->givePermissionTo('management news');

        $projectsManager = Role::create(['name'=>'projects Manager']);
        $projectsManager->givePermissionTo('management projects');

        $reliableResearcher = Role::create(['name'=>'reliable researcher']);
        $reliableResearcher->givePermissionTo($Researcher->permissions);
        $reliableResearcher->givePermissionTo('edit all articles');
        $reliableResearcher->givePermissionTo('management events');
        $reliableResearcher->givePermissionTo('management projects');

        $teacher = Role::create(['name'=>'teacher']);
        $teacher->givePermissionTo('teaching');

        $admin = Role::create(['name'=>'admin']);
        $admin->givePermissionTo(Permission::all());

    }
}
