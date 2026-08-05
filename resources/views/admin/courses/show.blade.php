<x-layout-menu-bar-private>
    <x-slot:title>
        Dettaglio Corso
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <div class="mb-6 mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Dati del corso
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Visualizza le informazioni di {{ $course->title }}
                </p>
            </div>

            <x-link-button href="/admin/courses">
                Indietro
            </x-link-button>
        </div>

        <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="flex items-center gap-4 p-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                    📘
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="truncate text-base font-semibold text-white">
                        {{ $course->title }}
                    </h2>

                    <div class="mt-1 flex flex-col items-start gap-2">
                        <span class="rounded-md border border-blue-400/20 bg-blue-500/10 px-2 py-1 text-xs font-bold tracking-wide text-blue-300">
                            {{ $course->code }}
                        </span>

                        <span class="text-xs text-gray-400">
                            Informazioni generali del corso
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="mb-5 text-base font-semibold text-white">
                    Informazioni
                </h2>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Titolo
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $course->title }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Lingua
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ ucfirst($course->language) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Codice
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $course->code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Crediti
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $course->points }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Semestre
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $course->semester }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Durata
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $course->duration }} ore
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Descrizione
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Contenuto e obiettivi del corso
                </p>

                <div class="rounded-lg border border-white/10 bg-white/5 p-4 text-sm leading-6 text-gray-300">
                    {!! $course->description !!}
                </div>
            </div>
        </div>

        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Docenti associati al corso
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Elenco dei docenti che partecipano al corso
                </p>

                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($course->teachers as $teacher)
                        <div class="flex items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3">
                        <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-blue-400/20 bg-blue-500/10">
                            @if ($teacher->profile_photo_url)
                                <img
                                    src="{{ $teacher->profile_photo_url }}"
                                    alt="Foto profilo di {{ $teacher->name }} {{ $teacher->surname }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-blue-300">
                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    {{ strtoupper(substr($teacher->surname, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-white">
                                    {{ $teacher->name }} {{ $teacher->surname }}
                                </p>

                                @if ($teacher->email)
                                    <p class="truncate text-xs text-gray-400">
                                        {{ $teacher->email }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-white/10 bg-white/5 px-4 py-3 sm:col-span-2">
                            <p class="text-sm text-gray-400">
                                Nessun docente associato al corso.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <form
            method="POST"
            action="/admin/courses/{{ $course->id }}"
            id="delete_course"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="mt-6 flex items-center justify-end gap-3 border-t border-white/10 py-5">
            <x-modify-button-link href="/admin/courses/{{ $course->id }}/edit">
                Modifica
            </x-modify-button-link>

            <x-danger-button form="delete_course">
                Elimina
            </x-danger-button>
        </div>
    </div>
</x-layout-menu-bar-private>