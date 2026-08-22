<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Enums\ProjectStatusType;
use illuminate\support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();

		$creators = User::permission('management projects')
		->select('id', 'name', 'surname')
		->orderBy('surname','asc')
		->orderBy('name', 'asc')
		->get();

		//se un il tizio che guarda può managementare i progetti può vedere tutti i progetti
		if($user->can('management projects')) $projects = Project::with('users')->with('creator')->when(
                $request->filled('userId'),
                function ($query) use ($request) {
                    $query->whereHas(
                        'creator',
                        function ($teacherQuery) use ($request) {
                            $teacherQuery->where(
                                'users.id',
                                $request->integer('userId')
                            );
                        }
                    );
                }
            )->latest()->paginate(8);
		//altrimenti può vedere solo i progetti a cui è associato
		else $projects = $user->projects()->with('users')->with('creator')
			->when(
                $request->filled('userId'),
                function ($query) use ($request) {
                    $query->whereHas(
                        'creator',
                        function ($teacherQuery) use ($request) {
                            $teacherQuery->where(
                                'users.id',
                                $request->integer('userId')
                            );
                        }
                    );
                }
            )->latest()->paginate(8);

		return view('admin.projects.index', compact('projects', 'creators'));
	}

	public function show(Project $project)
	{
		return view('admin.projects.show', compact('project'));
	}

	public function create()
	{
		//"statuses" e' grammaticalmente sbagliato ma lo uso per comodita' visto che "status" non cambia al plurare
		$statuses = ProjectStatusType::cases();
		$users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();

		return view('admin.projects.create', compact('users','statuses'));
	}

	public function store(){

		// validazione
		$validated = request()->validate([
			'title' => ['required','min:3','max:128', 'unique:projects,title'],
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
		$users = $validated['users'];

		DB::transaction(function () use ($projectData, $users) {
			// Creazione record nel Database
			$project = Project::create($projectData);
			$project->users()->attach($users);
			$project->creator()->associate(Auth::user());
		}
        );
	   
		return redirect()->route('admin.projects.index');
	}
	
	public function edit(Project $project)
	{
		$statuses = ProjectStatusType::cases();
		$users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();

		$project->load(['users']);

		return view('admin.projects.edit', compact('project', 'users','statuses'));
	}

	public function update(Project $project)
	{
		// validazione
		$validated = request()->validate([
			'title' => ['required','min:3','max:128', 'unique:projects,title'],
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
		$users = $validated['users'];

		DB::transaction(function () use ($project,$projectData, $users) {
			// aggiornamento record nel Database
			$project->update($projectData);
			$project->users()->sync($users);
		}
        );
	   
		return redirect()->route('admin.projects.show', $project);
	}

	public function destroy(Project $project)
	{
		$project->delete();

		return $this->redirectBackOrTo('admin.projects.index')->with(
                'success',
                'Progetto eliminato correttamente.'
            );
;
	}
}
