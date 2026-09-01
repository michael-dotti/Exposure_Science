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
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
			@forelse($projects as $project)
				<x-content-section>
                    <div class="ml-2 flex flex-col">
                        
                        <div class="justify-between">
                            <h2 class="text-xl font-bold text-white">
                                {{ $project->title }}
                            </h2>
                        </div>

                        @if($project->funding_agency)
                            <div class="mt-1 text-sm font-medium text-white">
                                Progetto finanziato da 
                                <span class="text-sm font-medium text-amber-400"> {{ $project->funding_agency }} </span>
                            </div>
                        @endif

                        <!-- partecipanti -->
                        <div class="mt-1 text-sm font-medium text-white"> 
                            Partecipano: @foreach($project->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach 
                        </div>

                        <!-- creatore -->
                        <div class="mt-1 text-sm font-medium text-white">
                            Creatore del progetto: {{ $project->creator->name }} {{ $project->creator->surname }}
                        </div>
                        
                        <!-- descrizione troncata -->
                        <div class="mt-1 text-sm font-medium text-white">
                            <p class="mt-3 text-sm leading-6 text-gray-300">
                                {{ \Illuminate\Support\Str::limit(strip_tags($project->description), 85) }}
                            </p>
                        </div>

                        <!-- LINK PER VISUALIZZARE (Separato dai bottoni) -->
                        <a href="{{ route('admin.projects.show', $project) }}" class="mt-2 inline-flex items-center text-sm font-semibold text-amber-300 hover:text-amber-200">
                            Visualizza progetto >
                        </a>

                        <hr class="h-px my-3 bg-gray-600 border-0">

                        <!-- pulsanti modifica e cancellazione -->
                        <div class="flex flex-wrap items-center gap-2">
                            @can('update', $project)
                                <x-modify-button-link href="{{ route('admin.projects.edit', $project) }}">Modifica</x-modify-button-link>
                            @endcan
                            
                            @can('delete', $project)
                                <x-danger-button form="delete_form_{{ $project->id }}">Elimina</x-danger-button>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form_{{ $project->id }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endcan
                        </div>

                    </div>
                </x-content-section>
			@empty
				<x-message-of-empty title="Nessun Progetto Trovato" image="fas fa-chart-bar" />
			@endforelse
		</div>
	</div>

	<div class="my-2">
		{{ $projects->links() }}
	</div>
</x-layout-private>