<x-course-project-show-layout
    :title="$course->title"
    back-title="Torna ai corsi"
    :back-href="route('public.courses.index')"
>

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
                Informazioni
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

                <p class="mt-3 wrap-break-word text-lg font-semibold text-white">
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

                <p class="mt-3 wrap-break-word text-lg font-semibold text-white">
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
                Descrizione
            </h2>

        </div>

        @if (filled(strip_tags($course->description ?? '')))

            <div class="course-project-content max-w-none wrap-break-word text-base leading-8 text-gray-300">
                {!! $course->description !!}
            </div>

        @else

            <p class="italic text-gray-400">
                Nessuna descrizione disponibile.
            </p>

        @endif

    </section>

</x-course-project-show-layout>