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

        Permission::create(['name'=>'edit all articles']);
        
        Permission::create(['name'=>'teaching']);
        Permission::create(['name'=>'manage all courses']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        $articleAdmin = Role::create(['name'=>'articles admin']);
        $articleAdmin->givePermissionTo('edit all articles'); 

        $newsManager = Role::create(['name'=>'news manager']);
        $newsManager->givePermissionTo('management news');

        $projectsManager = Role::create(['name'=>'projects manager']);
        $projectsManager->givePermissionTo('create projects');
        $projectsManager->givePermissionTo('manage my projects');

        $bigProjectsManager = Role::create(['name'=>'projects admin']);
        $bigProjectsManager->givePermissionTo($projectsManager->permissions);
        $bigProjectsManager->givePermissionTo('manage all projects');

        $eventsAdmin = Role::create(['name'=>'events admin']);
        $eventsAdmin->givePermissionTo('management events');

        $teacher = Role::create(['name'=>'teacher']);
        $teacher->givePermissionTo('teaching');

        $coursesAdmin = Role::create(['name'=>'courses admin']);
        $coursesAdmin->givePermissionTo($teacher->permissions);
        $coursesAdmin->givePermissionTo('manage all courses');
        
        $reliableResearcher = Role::create(['name'=>'reliable researcher']);
        $reliableResearcher->givePermissionTo($articleAdmin->permissions);
        $reliableResearcher->givePermissionTo($bigProjectsManager->permissions);
        $reliableResearcher->givePermissionTo($coursesAdmin->permissions);
        $reliableResearcher->givePermissionTo($eventsAdmin->permissions);
        
        $admin = Role::create(['name'=>'admin']);
        $admin->givePermissionTo(Permission::all()); // l'admin è l'unico utente che ha il permesso di gestire gli utenti

    }
}
