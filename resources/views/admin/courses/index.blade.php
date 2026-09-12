<x-layout-private>

    <x-slot:title>
        Corsi
    </x-slot:title>

    <x-dashboard-index-header
        title="Gestione corsi"
        subtitle="Visualizza e gestisci i corsi associati al tuo profilo"
    >
        <x-slot:actions>
            <x-button-create href="{{ route('admin.courses.create') }}">
                Nuovo Corso
            </x-button-create>
        </x-slot:actions>

        @can('manage all courses')
            <x-slot:filters>
                <x-filter-box
                    title="Filtra i corsi"
                    description="Seleziona un docente per visualizzare i corsi associati"
                    resetUrl="{{ route('admin.courses.index') }}"
                    :activeFilters="$currentFilters"
                >
                    <x-user-filter
                        title="Docente"
                        :users="$teachers"
                    />
                </x-filter-box>
            </x-slot:filters>
        @endcan
    </x-dashboard-index-header>

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
                    <x-modify-button-link
                        href="{{ route('admin.courses.edit', $course) }}"
                    >
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
            <x-message-of-empty
                title="Nessun corso trovato"
                image=""
            />
        @endforelse
    </div>

    <div class="my-6">
        {{ $courses->links() }}
    </div>

</x-layout-private>