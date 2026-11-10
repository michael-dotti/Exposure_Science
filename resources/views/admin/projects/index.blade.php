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

	<div class="space-y-3">
		@forelse($projects as $project)
			<x-index-card
				:href="route('admin.projects.show', $project)"
				:title="$project->title"
			>

				<x-slot:image>
					<div class="flex h-28 w-full flex-col items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5">
						<div class="text-4xl leading-none">
									@if($project->status == $statuses[3])
										<i class="fa-solid fa-diagram-predecessor text-green-300"></i>
									@elseif($project->status == $statuses[1])
										<i class="fa-solid fa-diagram-predecessor text-blue-300"></i>
									@elseif($project->status == $statuses[0])
										<i class="fa-solid fa-diagram-predecessor text-yellow-300"></i>
									@else
										<i class="fa-solid fa-diagram-predecessor text-pink-300"></i>
									@endif
								</div>

						<span class="mt-3 rounded-md border border-blue-400/20 bg-blue-500/10 px-2.5 py-1 text-xs font-bold tracking-wide text-blue-300">
							stato: 
								@if($project->status == $statuses[3])
									<span class="text-green-300">
								@elseif($project->status == $statuses[1])
									<span class="text-blue-300">
								@elseif($project->status == $statuses[0])
									<span class="text-yellow-300">
								@else
									<span class="text-pink-300">
								@endif

								{{ $project->status->label() }}
							</span>
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
								Nessun partecipante associato
							@endforelse
						</span>

					</div>
				</x-slot:people>

				<x-slot:details>
				</x-slot:details>

				<x-slot:description>
					{!! $project->description !!}
				</x-slot:description>

				<x-slot:actions>
					@can('update', $project)
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
					@endcan
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

	<div class="my-6">
        {{ $projects->links() }}
    </div>
</x-layout-private>