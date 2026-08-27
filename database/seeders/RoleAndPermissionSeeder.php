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

        Permission::create(['name'=>'create projects']);
        Permission::create(['name'=>'manage my projects']);
        Permission::create(['name'=>'manage all projects']);

        Permission::create(['name'=>'write articles']);
        Permission::create(['name'=>'edit own articles']);
        Permission::create(['name'=>'edit all articles']);
        Permission::create(['name'=>'teaching']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $Researcher = Role::create(['name'=>'researcher']);
        $Researcher->givePermissionTo('write articles'); 
        $Researcher->givePermissionTo('edit own articles');
        
        $newsManager = Role::create(['name'=>'news manager']);
        $newsManager->givePermissionTo('management news');

        $projectsManager = Role::create(['name'=>'projects manager']);
        $projectsManager->givePermissionTo('create projects');
        $projectsManager->givePermissionTo('manage my projects');

        $bigProjectsManager = Role::create(['name'=>'projects admin']);
        $bigProjectsManager->givePermissionTo($projectsManager->permissions);
        $bigProjectsManager->givePermissionTo('manage all projects');

        $reliableResearcher = Role::create(['name'=>'reliable researcher']);
        $reliableResearcher->givePermissionTo($Researcher->permissions);
        $reliableResearcher->givePermissionTo($bigProjectsManager->permissions);
        $reliableResearcher->givePermissionTo('edit all articles');
        $reliableResearcher->givePermissionTo('management events');

        $teacher = Role::create(['name'=>'teacher']);
        $teacher->givePermissionTo('teaching');

        $admin = Role::create(['name'=>'admin']);
        $admin->givePermissionTo(Permission::all());

    }
}
