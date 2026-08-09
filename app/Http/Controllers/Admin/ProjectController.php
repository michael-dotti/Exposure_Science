<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Enums\ProjectStatusType;
use illuminate\support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class ProjectController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		//se un il tizio che guarda può managementare i progetti può vedere tutti i progetti
		if($user->can('management projects')) $projects = Project::with('users')->paginate(8);
		//altrimenti può vedere solo i progetti a cui è associato
		else $projects = $user->projects()->paginate(8);

		return view('admin.projects.index', compact('projects'));
	}

	public function show(Project $project)
	{
		return view('admin.projects.show', compact('project'));
	}

	public function create()
	{
		//"statuses" e' grammaticalmente sbagliato ma lo uso per comodita' visto che "status" non cambia al plurare
		$statuses = ProjectStatusType::cases();
		$users = User::select('id', 'name')->get();

		return view('admin.projects.create', compact('users','statuses'));
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
		
		$users = request()->users;

		//rimuovo il creatore dall'array dei partecipanti
		//la sua incusione è trattata singolarmente
		//in questo modo ho la certezza di inserirlo e di inserirlo una sola volta
		if (($key = array_search(Auth::user()->id, $users)) !== false) {
			unset($users[$key]);
		}

		// Creazione record nel Database
		$project = Project::create($projectData);
		$project->users()->attach($users);
		$project->users()->attach(Auth::user());
		$project->creator()->associate(Auth::user());

		$project->save();
	   
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

		$users = request()->users;
		if (($key = array_search($project->creator_id, $users)) !== false) {
			unset($users[$key]);
		}
		$users[] = $project->creator_id;
		//dd($users);

		// updetazione record nel Database
		$project->update($projectData);
		$project->users()->sync($users);
	   
		return redirect()->route('admin.projects.show', $project);
	}

	public function destroy(Project $project)
	{
		$project->delete();

		return redirect()->route('admin.projects.index');
	}
}
