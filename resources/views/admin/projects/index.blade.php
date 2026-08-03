<x-layout-private>
	<x-slot:title>
		Projects Index
	</x-slot:title>
	
	<!-- div per contenere il pulsante di creazione -->

	<!-- div per il centramento -->
	<div class="pt-4 px-16 md:mx-8 sm:mx-4">
		<!-- div per la grigliatura -->
		<div class="grid grid-cols-2 gap-4 md:gap-3 sm:gap-2">
			@forelse($projects as $project)
				<!-- box del singolo progetto -->
				<article class="h-full rounded-lg border border-slate-700
						bg-gray-900 shadow-md transition duration-300
						hover:-translate-y-1 hover:shadow-xl">
						<a href="{{ route('admin.projects.show', $project) }}" class="ml-2 flex flex-col">
							<div class="justify-between p-3">
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

								<div class="inline-flex items-center text-sm font-semibold text-amber-300 hover:text-amber-200">
									Visualizza progetto >
								</div>

								<a href="{{ route('admin.projects.edit', $project) }}"
									class="rounded-lg mt-3 py-1 px-4
									bg-amber-300 hover:bg-amber-200
									inline-flex items-center justify-center text-sm font-semibold text-black">
									Modifica
								</a>

								<a href="{{ route('admin.projects.destroy', $project) }}"
									class="rounded-lg my-1 py-1 px-4
									bg-red-600 hover:bg-red-500
									inline-flex items-center justify-center text-sm font-semibold text-black">
									Elimina
								</a>
							</div>
						</a>
				</article>
			@empty
				<x-message-of-empty title="Nessun progetto trovato :("></x-message-of-empty>
			@endforelse
		</div>
	</div>

	<div class="mt-2">
		{{ $projects->links() }}
	</div>
</x-layout-private>