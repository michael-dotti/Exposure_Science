<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Mews\Purifier\Facades\Purifier;

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
        return view('admin.projects.create');
    }

    public function store(){

        // validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:128'],
            'description' =>['required','max:60000'],
            'users' => ['required', 'array', 'min:1'],
            'funding_agency' => ['nullable','min:3','max:128'],
            'status' => ['required','min:3','max:128'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after:start_date'],
        ]);
        
        // pulisco il testo da eventuali script malevoli
        $validated['description'] = Purifier::clean($validated['description']);

        $projectData = collect($validated)->except(['users', 'areas'])->toArray();

        // Creazione record nel Database
        $project = Project::create($projectData);

        
        $project->users()->attach(request()->users);

       
        return redirect()->route('admin.projects.index');
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
