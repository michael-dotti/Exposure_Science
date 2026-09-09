<x-layout-public>

    <x-slot:title>
        Corsi
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                I nostri corsi
            </h1>

            <p class="mx-auto mt-3 max-w-2xl text-base text-gray-300">
                Scopri i corsi offerti dal nostro gruppo di ricerca.
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="mx-auto max-w-4xl px-4 lg:px-6">

            {{-- Filtro dei corsi --}}
            <x-filter-box
                variant="public"
                title="Filtra i corsi"
                description="Seleziona un docente per visualizzare i corsi associati"
                resetUrl="{{ route('public.courses.index') }}"
                :activeFilters="$currentFilters"
            >
                <x-user-filter
                    title="Docente"
                    :users="$teachers"
                />
            </x-filter-box>

            @if ($courses->isEmpty())

                <x-message-of-empty
                    title="Al momento non sono presenti corsi"
                    image="fa-solid fa-person-chalkboard"
                />

            @else

                <div class="grid gap-5 md:grid-cols-2">

                    @foreach ($courses as $course)
                        <article
                            class="overflow-hidden rounded-lg border border-slate-700
                                   bg-gray-800 shadow-md transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <a
                                href="{{ route('public.courses.show', $course->id) }}"
                                class="flex h-full flex-col"
                            >
                                <div class="flex flex-1 flex-col justify-between p-4">

                                    <div>
                                        <h2 class="flex items-center justify-center text-xl font-bold text-white">
                                            {{ $course->title }}
                                        </h2>

                                        <p class="mt-1 flex items-center justify-center text-sm font-medium text-amber-400">
                                            Codice corso: {{ $course->code }}
                                        </p>

                                        <div class="mt-4 grid grid-cols-2 gap-2 text-sm text-gray-300">

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Lingua:
                                                </span>

                                                {{ $course->language }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Crediti:
                                                </span>

                                                {{ $course->points }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Semestre:
                                                </span>

                                                {{ $course->semester }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Durata:
                                                </span>

                                                {{ $course->duration }} ore
                                            </p>

                                        </div>

                                        {{-- Descrizione del corso --}}
                                        <p class="mt-4 text-sm leading-6 text-gray-300">
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($course->description),
                                                120
                                            ) }}
                                        </p>
                                    </div>

                                    <div class="mt-4">
                                        <span
                                            class="inline-flex items-center text-sm font-semibold
                                                   text-amber-300 hover:text-amber-200"
                                        >
                                            Visualizza corso

                                            <svg
                                                class="ml-2 h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        </span>
                                    </div>

                                </div>
                            </a>
                        </article>
                    @endforeach

                </div>

                {{-- Paginazione --}}
                <div class="mt-8 flex justify-center">
                    {{ $courses->links() }}
                </div>

            @endif

        </div>
    </section>

</x-layout-public>