<x-layout-private>
	<x-slot:title>
		Visualizzazione Progetto
	</x-slot:title>
	
	<div class="w-full max-w-4xl mx-auto mt-8">
		<article class="p-6 overflow-hidden rounded-lg border border-slate-700 bg-gray-800 shadow-md w-full min-h">
			<!-- titolo progetto -->
			<div class="mb-6 text-2xl font-bold text-white">{{ $project->title }}</div>
			<hr class="h-px my-6 bg-gray-600 border-0">

			<!-- stato -->
			<div class="mb-6 text-sm font-small text-gray-300">
				Stato attuale:

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
			</div>

			<!-- date del progetto -->
			<!-- se entrambe le date sono nulle si salta il div intero per non aggiungere inutile spazio -->
			@if($project->start_date || ($project->end_date))
				<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
					@if($project->start_date)
						<div> Data avvio: <span class="text-white"> {{ \Illuminate\Support\Carbon::parse($project->start_date)->format('d/m/Y') }} </span></div>
					@endif

					@if($project->end_date)
						<div> Data fine: <span class="text-white"> {{ \Illuminate\Support\Carbon::parse($project->end_date)->format('d/m/Y') }} </span> </div>
					@endif
				</div>
			@endif

			<!-- finanziatore -->
			@if($project->funding_agency)
				<div class="my-6 text-sm font-small text-white">
					Progetto finanziato con il gentile contributo di 
					<span class="text-amber-400">{{ $project->funding_agency }}</span>.
				</div>
			@endif

			<!-- partecipanti -->
			<div class="my-6 text-sm text-gray-300 flex flex-wrap items-center gap-2">
				@if($project->users->isEmpty())
					Partecipante: <span class="text-white">Nessun partecipante associato</span>
				@else
					@if($project->users->count() > 1) Partecipano al progetto:
					@else Partecipa al progetto:
					@endif 
					<span class="text-white">
						@foreach($project->users as $user)
							{{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif
						@endforeach
					</span>
				@endif
			</div>

			<!-- creatore -->
			<div class="my-6 text-sm text-gray-300 flex flex-wrap items-center gap-2">
				Creatore del progetto: 
				<span class="text-white">
					@if($project->creator)
						{{ $project->creator->name }} {{ $project->creator->surname }}
					@else
						Non specificato
					@endif
				</span>
			</div>

			<!-- descrizione del progetto -->
			<hr class="h-px my-6 bg-gray-600 border-0">

			<div class="text-xl font-bold text-amber-300">
				In cosa consiste il progetto
				
			</div>

			<div class="ml-2 mt-2 wrap-break-word text-sm font-medium text-gray-300">
				{!! $project->description !!}
			</div>

			<!-- pulsanti -->
			<div class="-ml-2 mt-8">
				<div class="flex items-center justify-between">
					<!-- pulsante di ritorno all'index -->
					<x-private-button-back :href="route('admin.projects.index')" class="flex justify-start"/>
					
					<!-- pulsanti modifica ed elimina -->
					<div class="flex items-center space-x-2.5">

						@can('update', $project)
							<x-modify-button-link href="{{ route('admin.projects.edit', $project) }}">Modifica</x-modify-button-link>
						@endcan

						@can('delete', $project)
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