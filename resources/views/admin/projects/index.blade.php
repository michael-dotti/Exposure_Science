<x-layout-private>
	<x-slot:title>
		@can('management projects') 
			I progetti del Team
		@endcan
		@cannot('management projects')
			I tuoi progetti
		@endcan
	</x-slot:title>
	
	<!-- pulsante di creazione -->
	@can('management projects') 
		<x-button-create href="{{ route('admin.projects.create') }}">Nuovo Progetto</x-button-create>
	@endcan

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

									<div class="mt-1 text-sm font-medium text-white"> Partecipano: @foreach($project->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach </div>

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
									@can('management projects') 
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