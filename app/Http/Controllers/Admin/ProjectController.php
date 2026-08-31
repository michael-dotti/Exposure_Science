<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Enums\ProjectStatusType;
use Illuminate\Validation\Rule;
use illuminate\support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();

		// Dati per i menu a tendina
    	$statuses = ProjectStatusType::cases();

		$creators = User::permission('manage all projects')
		->select('id', 'name', 'surname')
		->orderBy('surname','asc')
		->orderBy('name', 'asc')
		->get();


		// Carichiamo tutti gli utenti per il menu collaboratori (puoi filtrare se preferisci)
		$allUsers = User::select('id', 'name', 'surname')
			->orderBy('surname','asc')->orderBy('name', 'asc')->get();

		// Una sola riga per gestire permessi, relazioni, filtri URL e paginazione
		$projects = Project::visibleTo($user)
			->with(['users', 'creator'])
			->filterByCreator($request->integer('creatorId'))         // <--- NOTA: cambiato in creatorId
			->filterByCollaborator($request->integer('collaboratorId')) // <--- Nuovo
			->filterByStatus($request->query('status'))                 // <--- Nuovo
			->latest()
			->paginate(8)
			->withQueryString();

		// Prepariamo i filtri correnti per la UI (filter-box)
		$currentFilters = [];

		// Filtro: Creatore
		if ($request->filled('creatorId') && $selectedCreator = $creators->firstWhere('id', $request->integer('creatorId'))) {
			$currentFilters[] = [
				'label' => 'Creatore',
				'value' => $selectedCreator->name . ' ' . $selectedCreator->surname,
			];
		}

		// Filtro: Collaboratore
		if ($request->filled('collaboratorId') && $selectedCollab = $allUsers->firstWhere('id', $request->integer('collaboratorId'))) {
			$currentFilters[] = [
				'label' => 'Collaboratore',
				'value' => $selectedCollab->name . ' ' . $selectedCollab->surname,
			];
		}

		// Filtro: Stato (Usa l'enum per recuperare la label in italiano!)
		if ($request->filled('status') && $selectedStatus = ProjectStatusType::tryFrom($request->query('status'))) {
			$currentFilters[] = [
				'label' => 'Stato',
				'value' => $selectedStatus->label(), // Usa il metodo label() del tuo Enum
			];
		}

		return view('admin.projects.index', compact('projects', 'creators', 'allUsers', 'statuses', 'currentFilters'));
	}

	public function show(Project $project)
	{
		Gate::authorize('view', $project);

		return view('admin.projects.show', compact('project'));
	}

	public function create()
	{
		Gate::authorize('create', Project::class);
		//"statuses" e' grammaticalmente sbagliato ma lo uso per comodita' visto che "status" non cambia al plurare
		$statuses = ProjectStatusType::cases();
		$users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();

		return view('admin.projects.create', compact('users','statuses'));
	}

	public function store()
	{
		Gate::authorize('create', Project::class);

		// validazione
		$validated = request()->validate([
			'title' => ['required','min:3','max:128', 'unique:projects,title'],
			'description' =>['required','max:60000'],
			'users' => ['required', 'array', 'min:1'],
			'funding_agency' => ['nullable','min:3','max:128'],
			'status' => ['required', Rule::enum(ProjectStatusType::class)],
			'start_date' => ['nullable','date'],
			'end_date' => ['nullable','date','after:start_date'],
		]);
		
		// pulisco il testo da eventuali script malevoli
		$validated['description'] = Purifier::clean($validated['description']);

		$projectData = collect($validated)->except('users')->toArray();
		$users = $validated['users'];

		// inserisco nell'array il creatore del progetto, che è l'utente attualmente loggato
		$projectData['creator_id'] = Auth::id(); 

		DB::transaction(function () use ($projectData, $users) {
			// Creazione record nel Database
			$project = Project::create($projectData);
            $project->users()->attach($users);
		}
        );
	   
		return redirect()->route('admin.projects.index')->with(
                'success',
                'Progetto creato correttamente.'
            );
	}
	
	public function edit(Project $project)
	{
		Gate::authorize('update', $project);

		$statuses = ProjectStatusType::cases();
		$users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();

		$project->load(['users']);

		return view('admin.projects.edit', compact('project', 'users','statuses'));
	}

	public function update(Project $project)
	{
		Gate::authorize('update', $project);

		// validazione
		$validated = request()->validate([
			'title' => ['required', 'min:3', 'max:128', Rule::unique('projects')->ignore($project->id)],
			'description' =>['required','max:60000'],
			'users' => ['required', 'array', 'min:1'],
			'funding_agency' => ['nullable','min:3','max:128'],
			'status' => ['required', Rule::enum(ProjectStatusType::class)],
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
		Gate::authorize('delete', $project);
		$project->delete();

		return $this->redirectBackOrTo('admin.projects.index')->with(
                'success',
                'Progetto eliminato correttamente.'
            );
	}
}
