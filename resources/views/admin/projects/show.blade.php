<x-layout-private>
	<x-slot:title>
		Projects Show
	</x-slot:title>
	
	<div class="max-w-4xl mx-auto mt-8">
		<article class="p-6 overflow-hidden rounded-lg border border-slate-700 bg-gray-800 shadow-md">

			<div class="mb-6 text-sm font-small text-gray-300">
				Stato attuale:
				<span class="text-white"> {{ $project->status }} </span>
			</div>

			<div class="my-6 text-sm font-small text-gray-300 grid grid-cols-2">
				<div> Data avvio: <span class="text-white"> {{ $project->start_date }} </span></div>
				<div> Data fine: <span class="text-white"> {{ $project->end_date }} </span> </div>
			</div>

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

			<hr class="h-px my-6 bg-gray-600 border-0">

			<div class="text-xl font-bold text-amber-300">
				In cosa consiste il progetto
				
			</div>

			<div class="ml-2 mt-2 text-sm font-medium text-gray-300">
				{{ $project->description }}
			</div>

			<div class="-ml-2 mt-8">
				<div class="grid grid-cols-3 content-stretch">
					<a href="{{ route('admin.projects.index') }}"
						class="inline-flex w-fit items-center px-4 py-2 text-sm font-semibold
								text-slate-900 transition rounded-md bg-amber-300
								hover:bg-amber-200"
					>
						< Torna ai progetti
					</a>
					<div></div>
					<div class="justify-self-end-safe">
						<x-modify-button-link href="{{ route('admin.projects.edit', $project) }}">Modifica</x-modify-button-link>
						<x-danger-button form="delete_form_{{ $project->id }}" >Elimina</x-danger-button>
						<form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form_{{ $project->id }}" class="hidden">
							@csrf
							@method('DELETE')
						</form>
					</div>
				</div>
			</div>
		</article>
	</div>

</x-layout-private>