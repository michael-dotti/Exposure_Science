<x-layout-public>
	<x-slot:title>
		Progetti
	</x-slot:title>
	<x-slot:heading>
		<div class="py-5 text-center">
			<h1 class="text-3xl font-bold text-amber-300">
				I nostri progetti
			</h1>

			<p class="max-w-2xl mx-auto mt-3 text-base text-gray-300">
				Scopri dove l'impegno dei nostri ricercatori viene allocato.
			</p>
		</div>
	</x-slot:heading>

	<div class="max-w-4xl mx-auto">
		<!-- controlle se ci sono progetti nel sito -->
		@if ($projects->isEmpty())
			<div class="py-10 text-center">
				<p class="text-base text-gray-300">
					Al momento non sono presenti progetti.
				</p>
			</div>
		@else
			<div class="grid grid-cols-2 gap-4">
				<!-- ciclo sui progetti nel sito (i tot che paginate del controller mi ha dato) -->
				@foreach($projects as $project)
					<!-- riquadro del singolo progetto (ho ripreso lo stile dei riquadri del team e dei corsi) -->
					<article class="overflow-hidden rounded-lg border border-slate-700
									bg-gray-800 shadow-md transition duration-300
									hover:-translate-y-1 hover:shadow-xl"
						>
						<!-- linkaggio al singolo progetto -->
						<a href="/public/projects/{{ $project->id }}" class="flex flex-col h-full ml-2 sm:flex-row">
							<div class="flex flex-col justify-between flex-1 p-3">
								<div>
									<h2 class="text-xl font-bold text-white">
										{{ $project->title }}
									</h2>
								</div>

								<div class="mt-1 text-sm font-medium text-white">
									Progetto finanziato da 
									<span class="text-sm font-medium text-amber-400"> {{ $project->funding_agency }} </span>
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

								<div class="mt-7 inline-flex items-center text-sm font-semibold text-amber-300 hover:text-amber-200">
									Visualizza progetto >
								</div>
							</div>
						</a>
					</article>
				@endforeach
			</div>
		@endif
	</div>

	<!-- numerazione per la paginazione -->
	<div class="mt-2">
		{{ $projects->links() }}
	</div>
</x-layout-public>
