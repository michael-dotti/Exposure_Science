<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Enums\ProjectStatusType;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('users')
            ->filterByStatus($request->query('status'))
            ->paginate(8)
            ->withQueryString();
        
        $statuses = ProjectStatusType::cases();

        return view('public.projects.index',compact('projects','statuses'));
    }

    public function show(Project $project)
    {
        return view('public.projects.show',compact('project'));
    }

}
