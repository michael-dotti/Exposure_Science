<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
		$users = User::select('id', 'name')->get();
		return view('admin.projects.create', ['users' => $users]);
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

		$projectData = collect($validated)->except('users')->toArray();

		// Creazione record nel Database
		$project = Project::create($projectData);
		$project->users()->attach(request()->users);

	   
		return redirect()->route('admin.projects.index');
	}
	
	public function edit(Project $project)
	{
		$users = User::select('id', 'name')->get();

		$project->load(['users']);

		return view('admin.projects.edit', compact('project', 'users'));
	}

	public function update(Project $project)
	{
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

		$projectData = collect($validated)->except(['users'])->toArray();

		// updetazione record nel Database
		$project->update($projectData);
		$project->users()->sync($validated['users']);
	   
		return redirect()->route('admin.projects.show', $project);
	}

	public function destroy(Project $project)
	{
		$project->delete();

		return redirect()->route('admin.projects.index');
	}
}
