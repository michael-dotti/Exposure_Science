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

        <x-button-create href="{{ route('admin.courses.create') }}">
            Nuovo Corso
        </x-button-create>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <x-filter-box
    title="Filtra per docente"
    description="Seleziona un docente per visualizzare i corsi associati"
>

    <x-user-filter
        title="Docente"
        href="/admin/courses"
        :users="$teachers"
    />

    @if (request()->filled('userId'))
        <a
            href="{{ route('admin.courses.index') }}"
            class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
        >
            Rimuovi filtro
        </a>
    @endif

    @if (request()->filled('userId'))
        @php
            $selectedTeacher = $teachers->firstWhere('id', request('userId'));
        @endphp

        @if ($selectedTeacher)
            <x-slot:activeFilters>
                <span class="rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
                    Docente:
                    {{ $selectedTeacher->name }}
                    {{ $selectedTeacher->surname }}
                </span>
            </x-slot:activeFilters>
        @endif
    @endif

</x-filter-box>

    <div class="space-y-3">
        @forelse ($courses as $course)

            <x-index-card
                :href="route('admin.courses.show', $course)"
                :title="$course->title"
            >

                <x-slot:image>
                    <div class="flex h-28 w-full flex-col items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5">
                        <div class="text-4xl leading-none">
                            <i class="fa-solid fa-graduation-cap text-blue-300"></i>
                        </div>

                        <span class="mt-3 rounded-md border border-blue-400/20 bg-blue-500/10 px-2.5 py-1 text-xs font-bold tracking-wide text-blue-300">
                            {{ $course->code }}
                        </span>
                    </div>
                </x-slot:image>

                <x-slot:people>
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
                </x-slot:people>

                <x-slot:badge>
                    <span class="w-fit rounded-full border border-blue-400/20 bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-300">
                        {{ ucfirst($course->language) }}
                    </span>
                </x-slot:badge>

                <x-slot:details>
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
                </x-slot:details>

                <x-slot:description>
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($course->description),
                        180
                    ) }}
                </x-slot:description>

                <x-slot:actions>
                    <x-modify-button-link href="{{ route('admin.courses.edit', $course) }}">
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
                        action="{{ route('admin.courses.destroy', $course) }}"
                        id="delete_form_{{ $course->id }}"
                        class="hidden"
                    >
                        @csrf
                        @method('DELETE')
                    </form>
                </x-slot:actions>

            </x-index-card>

        @empty
            <x-message-of-empty title="Nessun corso trovato">
            </x-message-of-empty>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
    </x-layout-private>