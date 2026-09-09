<x-layout-public>

    <x-slot:title>
        Progetti
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                I nostri progetti
            </h1>

            <p class="mx-auto mt-3 max-w-2xl text-base text-gray-300">
                Scopri dove l'impegno dei nostri ricercatori viene allocato.
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="mx-auto max-w-4xl px-4 lg:px-6">

            {{-- Filtro dei progetti --}}
            <x-filter-box
                variant="public"
                title="Filtra i progetti"
                description="Seleziona uno stato per visualizzare i progetti corrispondenti"
                resetUrl="{{ route('public.projects.index') }}"
                :activeFilters="$currentFilters"
            >
                <x-project-status-filter
                    :statuses="$statuses"
                />
            </x-filter-box>

            @if ($projects->isEmpty())

                <x-message-of-empty
                    title="Al momento non sono presenti progetti"
                    image="fas fa-chart-bar"
                />

            @else

                <div class="grid gap-5 md:grid-cols-2">

                    @foreach ($projects as $project)
                        <article
                            class="overflow-hidden rounded-lg border border-slate-700
                                   bg-gray-800 shadow-md transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <a
                                href="{{ route('public.projects.show', $project) }}"
                                class="flex h-full flex-col"
                            >
                                <div class="flex flex-1 flex-col justify-between p-5">

                                    <div>
                                        <div class="flex items-start justify-between gap-3">
                                            <h2 class="min-w-0 text-xl font-bold text-white">
                                                {{ $project->title }}
                                            </h2>

                                        </div>

                                        @if ($project->funding_agency)
                                            <p class="mt-3 text-sm text-gray-300">
                                                Finanziato da

                                                <span class="font-semibold text-amber-400">
                                                    {{ $project->funding_agency }}
                                                </span>
                                            </p>
                                        @endif

                                        @if ($project->start_date || $project->end_date)
                                            <div class="mt-4 grid grid-cols-1 gap-2 text-sm text-gray-300 sm:grid-cols-2">

                                                @if ($project->start_date)
                                                    <p>
                                                        <span class="font-semibold text-white">
                                                            Data di avvio:
                                                        </span>

                                                        {{ \Illuminate\Support\Carbon::parse($project->start_date)->format('d/m/Y') }}
                                                    </p>
                                                @endif

                                                @if ($project->end_date)
                                                    <p>
                                                        <span class="font-semibold text-white">
                                                            Data di fine:
                                                        </span>

                                                        {{ \Illuminate\Support\Carbon::parse($project->end_date)->format('d/m/Y') }}
                                                    </p>
                                                @endif

                                            </div>
                                        @endif

                                        <p class="mt-4 text-sm leading-6 text-gray-300">
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($project->description),
                                                120
                                            ) }}
                                        </p>
                                    </div>

                                    <div class="mt-5">
                                        <span class="inline-flex items-center text-sm font-semibold text-amber-300 hover:text-amber-200">
                                            Visualizza progetto

                                            <i
                                                class="fa-solid fa-arrow-right ml-2 text-xs"
                                                aria-hidden="true"
                                            ></i>
                                        </span>
                                    </div>

                                </div>
                            </a>
                        </article>
                    @endforeach

                </div>

                <div class="mt-8 flex justify-center">
                    {{ $projects->links() }}
                </div>

            @endif

        </div>
    </section>

</x-layout-public>