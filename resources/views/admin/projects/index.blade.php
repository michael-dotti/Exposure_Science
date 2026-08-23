<x-layout-private>
	<x-slot:title>
		@can('manage all projects') 
			I progetti del Team
		@endcan
		@cannot('manage all projects')
			I tuoi progetti
		@endcan
	</x-slot:title>
	
	<!-- pulsante di creazione -->
	@can('create projects') 
		<x-button-create href="{{ route('admin.projects.create') }}">Nuovo Progetto</x-button-create>
	@endcan

	@if (session('success'))
		<div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
			{{ session('success') }}
		</div>
	@endif

	<div class="mt-2"></div>

	<x-filter-box
		title="Filtra i progetti"
		description="secondo creatore, collaboratore o area"
	>

	<x-user-filter
		title="Creatore"
		href="{{ route('admin.projects.index') }}"
		:users="$creators"
	/>

	@if (request()->filled('userId'))
		<a
			href="{{ route('admin.projects.index') }}"
			class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
		>
			Rimuovi filtro
		</a>
	@endif

	@if (request()->filled('userId'))
		@php
			$selectedCreator = $creators->firstWhere('id', request('userId'));
		@endphp

		@if ($selectedCreator)
			<x-slot:activeFilters>
				<span class="rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
					Creatore:
					{{ $selectedCreator->name }}
					{{ $selectedCreator->surname }}
				</span>
			</x-slot:activeFilters>
		@endif
	@endif

	</x-filter-box>

	<!-- div per il centramento -->
	<div class="pt-4 px-16 md:mx-8 sm:mx-4">
		<!-- div per la grigliatura -->
			@forelse($projects as $project)
				<div class="grid grid-cols-2 gap-4 md:gap-3 sm:gap-2"></div>
					<!-- box del singolo progetto -->
					<x-content-section>
							<a href="{{ route('admin.projects.show', $project) }}" class="ml-2 flex flex-col">
								<div class="justify-between">
									<div>
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
								<div class="mt-1 text-sm font-medium text-white"> Partecipano: @foreach($project->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach </div>

								<!-- creatore -->
								<div class="mt-1 text-sm font-medium text-white">
									<div> Creatore al progetto: {{ $project->creator->name }} {{ $project->creator->surname }}</div>
								</div>
								
								<!-- descrizione troncata per non far occupare troppo spazio -->
								<div class="mt-1 text-sm font-medium text-white">
									<p class="mt-3 text-sm leading-6 text-gray-300">
										{{ \Illuminate\Support\Str::limit(
											strip_tags($project->description),
											85
										) }}
									</p>
								</div>

									<div class="inline-flex items-center text-sm font-semibold text-amber-300 hover:text-amber-200">
										Visualizza progetto >
									</div>

									<hr class="h-px my-3 bg-gray-600 border-0">

								<!-- pulsanti modifica e cancellazione con annesso controllo -->
								@canany(['manage all projects', 'manage my projects'])
									<x-modify-button-link href="{{ route('admin.projects.edit', $project) }}">Modifica</x-modify-button-link>
									<x-danger-button form="delete_form_{{ $project->id }}" >Elimina</x-danger-button>
									<form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form_{{ $project->id }}" class="hidden">
										@csrf
										@method('DELETE')
									</form>
								@endcan

								</div>
							</a>
					</x-content-section>
				</div>
			@empty
				<x-message-of-empty title="Nessun Progetto Trovato" image="fas fa-chart-bar" />
			@endforelse
	</div>

	<div class="my-2">
		{{ $projects->links() }}
	</div>
</x-layout-private>