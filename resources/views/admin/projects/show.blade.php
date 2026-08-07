<x-layout-private>
	<x-slot:title>
		{{ $project->title }}
	</x-slot:title>
	
	<div class="max-w-4xl mx-auto mt-8">
		<article class="p-6 overflow-hidden rounded-lg border border-slate-700 bg-gray-800 shadow-md">
			<!-- titolo progetto -->
			<div class="mb-6 text-2xl font-bold text-white">{{ $project->title }}</div>
			<hr class="h-px my-6 bg-gray-600 border-0">

			<!-- stato -->
			<div class="mb-6 text-sm font-small text-gray-300">
				Stato attuale:
				<span class="text-white"> {{ $project->status }} </span>
			</div>

			<!-- date del progetto -->
			<!-- se entrambe le date sono nulle si salta il div intero per non aggiungere inutile spazio -->
			@if($project->start_date || ($project->end_date))
				<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
					@if($project->start_date)
						<div> Data avvio: <span class="text-white"> {{ $project->start_date }} </span></div>
					@endif

					@if($project->end_date)
						<div> Data fine: <span class="text-white"> {{ $project->end_date }} </span> </div>
					@endif
				</div>
			@endif

			<!-- finanziatore -->
			@if($project->funding_agency)
				<div class="my-6 text-sm font-small text-white">
					Progetto finanziato con il gentile contributo di 
					<span class="text-amber-400">{{ $project->funding_agency }}</span>.
				</div>
			@elseif(random_int(0,1000) == 69)
				<div class="my-6 text-sm font-small text-white">
					Progetto finanziato con il gentile contributo di tua mamma.
				</div>
			@endif

			<!-- partecipanti -->
			<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
				<div> @if(sizeof($project->users) > 1) Partecipano al progetto:
					@else Partecipa al progetto:
					@endif <span class="text-white">@foreach($project->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach</span></div>
			</div>

			<!-- descrizione del progetto -->
			<hr class="h-px my-6 bg-gray-600 border-0">

			<div class="text-xl font-bold text-amber-300">
				In cosa consiste il progetto
				
			</div>

			<div class="ml-2 mt-2 text-sm font-medium text-gray-300">
				{!! $project->description !!}
			</div>

			<!-- pulsanti -->
			<div class="-ml-2 mt-8">
				<div class="grid grid-cols-3 content-stretch">
					<!-- pulsante di ritorno all'index -->
					<a href="{{ route('admin.projects.index') }}"
						class="inline-flex w-fit items-center px-4 py-2 text-sm font-semibold
								text-slate-900 transition rounded-md bg-amber-300
								hover:bg-amber-200"
					>
						< Torna ai progetti
					</a>
					<!-- spazio vuoto -->
					<div></div>
					<!-- pulsanti modifica ed elimina -->
					<div class="justify-self-end-safe">
						@can('management projects') 
							<x-modify-button-link href="{{ route('admin.projects.edit', $project) }}">Modifica</x-modify-button-link>
							<x-danger-button form="delete_form_{{ $project->id }}" >Elimina</x-danger-button>
							<form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form_{{ $project->id }}" class="hidden">
								@csrf
								@method('DELETE')
							</form>
						@endcan
					</div>
				</div>
			</div>
		</article>
	</div>

</x-layout-private>