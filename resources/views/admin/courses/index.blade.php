<x-layout-private>
    <x-slot:title>
        Corsi
    </x-slot:title>

    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">
                Gestione corsi
            </h1>

            <p class="mt-1 text-xs text-gray-400">
                Visualizza e gestisci i corsi associati al tuo profilo
            </p>
        </div>

        <x-button-create href="/admin/courses/create">
            Nuovo Corso
        </x-button-create>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtro docenti --}}
    <div class="mb-4 rounded-lg border border-white/10 bg-white/3 px-4 py-3">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-sm font-semibold text-white">
                    Filtra per docente
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Seleziona un docente per visualizzare i corsi associati
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row">
                <x-user-filter
                    title="Docente"
                    href="/admin/courses"
                    :users="$teachers"
                />

                @if (request()->filled('userId'))
                    <a
                        href="/admin/courses"
                        class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
                    >
                        Rimuovi filtro
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Elenco corsi --}}
    <div class="space-y-3">
        @forelse ($courses as $course)
            <article
                class="group relative overflow-hidden rounded-lg border border-white/10 bg-slate-800/40 shadow-sm transition duration-200 hover:border-blue-400/40 hover:bg-slate-800/60"
            >
                {{-- Link invisibile che rende cliccabile tutta la scheda --}}
                <a
                    href="/admin/courses/{{ $course->id }}"
                    class="absolute inset-0 z-10"
                    aria-label="Visualizza il corso {{ $course->title }}"
                ></a>

                {{-- Bordo blu laterale --}}
                <div class="pointer-events-none absolute bottom-0 left-0 top-0 w-1 bg-blue-500"></div>

                {{-- Contenuto della scheda --}}
                <div class="pointer-events-none relative z-20 flex flex-col sm:flex-row">
                    {{-- Icona e codice --}}
                    <div class="flex items-center justify-center border-b border-white/10 bg-slate-900/30 p-4 sm:w-36 sm:border-b-0 sm:border-r">
                        <div class="flex h-28 w-full flex-col items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5">
                            <div class="text-4xl leading-none">
                                📘
                            </div>

                            <span class="mt-3 rounded-md border border-blue-400/20 bg-blue-500/10 px-2.5 py-1 text-xs font-bold tracking-wide text-blue-300">
                                {{ $course->code }}
                            </span>
                        </div>
                    </div>

                    {{-- Informazioni corso --}}
                    <div class="min-w-0 flex-1 p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <h2 class="text-lg font-bold text-white transition group-hover:text-blue-300">
                                    {{ $course->title }}
                                </h2>

                                <div class="mt-1 flex flex-wrap items-center gap-1 text-sm">
                                    <span class="font-semibold text-blue-400">
                                        Docenti:
                                    </span>

                                    <span class="text-gray-300">
                                        @forelse ($course->teachers as $teacher)
                                            {{ $teacher->name }}
                                            {{ $teacher->surname }}@if (!$loop->last), @endif
                                        @empty
                                            Nessun docente associato
                                        @endforelse
                                    </span>
                                </div>
                            </div>

                            <span class="w-fit rounded-full border border-blue-400/20 bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-300">
                                {{ ucfirst($course->language) }}
                            </span>
                        </div>

                        {{-- Informazioni sintetiche --}}
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-gray-300">
                                {{ $course->points }} crediti
                            </span>

                            <span class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-gray-300">
                                Semestre {{ $course->semester }}
                            </span>

                            <span class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-gray-300">
                                {{ $course->duration }} ore
                            </span>
                        </div>

                        {{-- Descrizione --}}
                        <p class="mt-3 text-sm leading-5 text-gray-400">
                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($course->description),
                                180
                            ) }}
                        </p>

                        {{-- Pulsanti --}}
                        <div class="pointer-events-auto relative z-30 mt-4 flex flex-wrap items-center gap-2 border-t border-white/10 pt-3">
                            <x-modify-button-link href="/admin/courses/{{ $course->id }}/edit">
                                Modifica
                            </x-modify-button-link>

                            <x-danger-button
                                type="submit"
                                form="delete_form_{{ $course->id }}"
                            >
                                Elimina
                            </x-danger-button>

                            <form
                                method="POST"
                                action="/admin/courses/{{ $course->id }}"
                                id="delete_form_{{ $course->id }}"
                                class="hidden"
                            >
                                @csrf
                                @method('DELETE')
                            </form>

                            <span class="pointer-events-none ml-0 text-xs font-semibold text-blue-400 transition group-hover:text-blue-300 sm:ml-auto">
                                Visualizza dettagli →
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <x-message-of-empty title="Nessun corso trovato">
            </x-message-of-empty>
        @endforelse
    </div>

    {{-- Paginazione --}}
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</x-layout-menu-bar-private>