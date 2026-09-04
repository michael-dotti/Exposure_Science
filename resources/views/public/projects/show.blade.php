<x-layout-public>
	<x-slot:title>
		{{ $project->title }}
	</x-slot:title>
	<x-slot:heading>
		{{ $project->title }}
	</x-slot:heading>
	
	<div class="max-w-4xl mx-auto">
		<article class="p-6 overflow-hidden rounded-lg border border-slate-700 bg-gray-800 shadow-md">

			<div class="mb-6 text-sm font-small text-gray-300">
				Stato attuale:
				<span class="text-white"> {{ $project->status->label() }} </span>
			</div>

			@if($project->start_date || ($project->end_date))
				<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
					@if($project->start_date)
						<div> Data avvio: <span class="text-white"> {{ $project->start_date }} </span></div>
					@endif

					@if($project->start_date)
						<div> Data fine: <span class="text-white"> {{ $project->end_date }} </span> </div>
					@endif
				</div>
			@endif

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

			<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
				<div> @if(sizeof($project->users) > 1) Partecipano al progetto:
					@else Partecipa al progetto:
					@endif
					<span class="text-white">@foreach($project->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach</span></div>
			</div>

			<hr class="h-px my-6 bg-gray-600 border-0">

			<div class="text-xl font-bold text-amber-300">
				In cosa consiste il progetto
				
			</div>

			<div class="ml-2 mt-2 text-sm font-medium text-gray-300 [overflow-wrap:anywhere]">
				{!! $project->description !!}
			</div>

			<div class="-ml-2 mt-8">
				<x-public-botton-back title="Torna ai progetti" :href="route('public.projects.index')" />
			</div>
		</article>
	</div>

</x-layout-public>