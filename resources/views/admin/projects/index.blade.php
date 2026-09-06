<x-layout-private>
	<x-slot:title>
		@can('manage all projects') 
			Progetti del Team
		@else
			I Tuoi Progetti
		@endcan
	</x-slot:title>
	
	<x-dashboard-index-header
		:title="auth()->user()->can('manage all projects') ? 'Gestisci Progetti' : 'Visualizza Progetti'"
        :subtitle="auth()->user()->can('manage all projects') 
		? 'Visualizza e gestisci i progetti presenti nel portale' 
		: (auth()->user()->can('manage my projects') 
			? 'Visualizza e gestisci i tuoi progetti' 
			:'Visualizza i progetti che ti sono stati assegnati')"
	>
		<x-slot:actions>
			@can('create projects') 
				<x-button-create href="{{ route('admin.projects.create') }}">Nuovo Progetto</x-button-create>
			@endcan
		</x-slot:actions>

		
		<x-slot:filters>
			<x-filter-box
				title="Filtra i progetti"
				description="secondo creatore, collaboratore o area"
				resetUrl="{{ route('admin.projects.index') }}"
				:activeFilters="$currentFilters"
			>

				{{-- FILTRO STATO --}}
    			<x-project-status-filter :statuses="$statuses" />

				{{-- FILTRO COLLABORATORI (Manager e Project Admin) --}}
				@can('manage my projects')
					<x-user-filter 
						:users="$allUsers" 
						title="Collaboratore" 
						paramName="collaboratorId" 
					/>
				@endcan

				{{-- FILTRO CREATORI (Solo project Admin) --}}
				@can('manage all projects')
					<x-user-filter 
						:users="$creators" 
						title="Creatore" 
						paramName="creatorId" 
					/>
				@endcan
			</x-filter-box>
		</x-slot:filters>

	</x-dashboard-index-header>

	
	<!-- div per il centramento -->
	<div class="pt-4 px-4 sm:px-6 md:px-8">
		<!-- div per la grigliatura -->
		<div class="grid grid-cols-1 md:grid-cols-1 gap-4">
			@forelse($projects as $project)
				<x-index-card
						:href="route('admin.projects.show', $project)"
						:title="$project->title"
					>

						<x-slot:image>
							<div class="flex h-28 w-full flex-col items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5">
								<div class="text-4xl leading-none">
									<i class="fa-solid fa-diagram-predecessor text-blue-300"></i>
								</div>

								<span class="mt-3 rounded-md border border-blue-400/20 bg-blue-500/10 px-2.5 py-1 text-xs font-bold tracking-wide text-blue-300">
									stato: {{ $project->status }}
								</span>
							</div>
						</x-slot:image>

						<x-slot:people>
							<div class="mt-1 flex flex-wrap items-center gap-1 text-sm">

								<span class="font-semibold text-blue-400">
									Partecipanti:
								</span>

								<span class="text-gray-300">
									@forelse ($project->users as $user)
										{{ $user->name }}
										{{ $user->surname }}@if (!$loop->last), @endif
									@empty
										Nessun autore associato
									@endforelse
								</span>

							</div>
						</x-slot:people>

						<x-slot:details>
						</x-slot:details>

						<x-slot:description>
							{{ \Illuminate\Support\Str::limit(
								strip_tags($project->description),
								180
							) }}
						</x-slot:description>

						<x-slot:actions>
							<x-modify-button-link
								href="{{ route('admin.projects.edit', $project) }}"
							>
								Modifica
							</x-modify-button-link>
						
							<x-danger-button
								type="submit"
								form="delete_form_{{ $project->id }}"
							>
								Elimina
							</x-danger-button>

							<form
								method="POST"
								action="{{ route('admin.projects.destroy', $project) }}"
								id="delete_form_{{ $project->id }}"
								class="hidden"
							>
								@csrf
								@method('DELETE')
							</form>
						</x-slot:actions>
					</x-index-card>
			@empty
				<x-message-of-empty title="Nessun Progetto Trovato" image="fas fa-chart-bar" />
			@endforelse
		</div>
		@foreach($projects as $project)
			@can('delete', $project)
				<form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form_{{ $project->id }}" class="hidden">
					@csrf
					@method('DELETE')
				</form>
			@endcan
		@endforeach

	</div>

	<div class="my-2">
		{{ $projects->links() }}
	</div>
</x-layout-private>