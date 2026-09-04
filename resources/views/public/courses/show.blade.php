<x-layout-public>
    <x-slot:title>
        {{ $course->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">

            <h1 class="break-words text-3xl font-bold leading-tight text-amber-300">
                {{ $course->title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante fuori dalla scheda --}}
        <div class="mb-8">
            <x-public-botton-back
                title="Torna ai corsi"
                :href="route('public.courses.index')"
            />
        </div>

        <article class="overflow-hidden rounded-2xl border border-white/10 bg-gray-800 shadow-2xl">

            {{-- Dati principali --}}
            <section class="p-6 sm:p-8 lg:p-10">

                <div class="mb-7 flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-amber-400/20 bg-amber-400/10 text-amber-300">
                        <i
                            class="fa-solid fa-graduation-cap"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <h2 class="text-xl font-bold text-white">
                        Informazioni sul corso
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

                    {{-- Lingua --}}
                    <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i
                                class="fa-solid fa-language text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="text-xs font-bold uppercase tracking-wider">
                                Lingua
                            </span>
                        </div>

                        <p class="mt-3 break-words text-lg font-semibold text-white">
                            {{ ucfirst($course->language) }}
                        </p>
                    </div>

                    {{-- Codice --}}
                    <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i
                                class="fa-solid fa-code text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="text-xs font-bold uppercase tracking-wider">
                                Codice
                            </span>
                        </div>

                        <p class="mt-3 break-words text-lg font-semibold text-white">
                            {{ $course->code }}
                        </p>
                    </div>

                    {{-- Crediti --}}
                    <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i
                                class="fa-solid fa-award text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="text-xs font-bold uppercase tracking-wider">
                                Crediti
                            </span>
                        </div>

                        <p class="mt-3 text-lg font-semibold text-white">
                            {{ $course->points }}
                        </p>
                    </div>

                    {{-- Semestre --}}
                    <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i
                                class="fa-regular fa-calendar text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="text-xs font-bold uppercase tracking-wider">
                                Semestre
                            </span>
                        </div>

                        <p class="mt-3 text-lg font-semibold text-white">
                            {{ $course->semester }}
                        </p>
                    </div>

                    {{-- Durata --}}
                    <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i
                                class="fa-regular fa-clock text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="text-xs font-bold uppercase tracking-wider">
                                Durata
                            </span>
                        </div>

                        <p class="mt-3 text-lg font-semibold text-white">
                            {{ $course->duration }} ore
                        </p>
                    </div>

                </div>
            </section>

            {{-- Descrizione --}}
            <section class="border-t border-white/10 bg-gray-900/60 p-6 sm:p-8 lg:p-10">

                <div class="mb-5 flex items-center gap-3">
                    <i
                        class="fa-solid fa-align-left text-amber-300"
                        aria-hidden="true"
                    ></i>

                    <h2 class="text-xl font-bold text-white">
                        Descrizione del corso
                    </h2>
                </div>

                @if (filled(strip_tags($course->description ?? '')))
                    <div class="course-content max-w-none break-words text-base leading-8 text-gray-300 [overflow-wrap:anywhere]">
                        {!! $course->description !!}
                    </div>
                @else
                    <p class="italic text-gray-400">
                        Nessuna descrizione disponibile.
                    </p>
                @endif

            </section>

        </article>
    </main>

    @push('styles')
        <style>
            .course-content,
            .course-content p {
                max-width: 100%;
                overflow-wrap: anywhere;
                white-space: normal;
            }

            .course-content p {
                margin-bottom: 1rem;
            }

            .course-content ul {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: disc;
            }

            .course-content ol {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: decimal;
            }

            .course-content a {
                color: rgb(34 211 238);
                text-decoration: underline;
            }
        </style>
    @endpush
</x-layout-public>