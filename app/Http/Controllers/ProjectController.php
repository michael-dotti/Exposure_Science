<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->paginate(8);
        return view('public.projects.index',compact('projects'));
    }

    public function show(Project $project)
    {
        return view('public.projects.show',compact('project'));
    }

}
