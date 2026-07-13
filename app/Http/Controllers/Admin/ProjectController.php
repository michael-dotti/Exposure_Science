<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->paginate(8);
        return view('admin.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    

    public function create()
    {
        dd("TODO");
    }

    public function store(){
        dd("TODO");
        // 1) validazione
        // 2) intervention Image (se c'è foto profilo)
        // 3) caricare la foto profilo nello storage
        // 4) creare nuovo User
        // 5) redirect
    }
    
    public function edit()
    {
        dd("TODO");
    }
    public function update()
    {
        dd("TODO");
    }

    public function destroy()
    {
        dd("TODO");
    }
}
