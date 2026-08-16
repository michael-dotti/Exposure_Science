<x-show-page
    pageTitle="Dettaglio Corso"
    heading="Dati del corso"
    :backHref="route('admin.courses.index')"
    :title="$course->title"
>

    <x-slot:icon>
        <i class="fa-solid fa-graduation-cap text-blue-300"></i>
    </x-slot:icon>

    <x-slot:headerInfo>

        <span class="rounded-md border border-blue-400/20 bg-blue-500/10 px-2 py-1 text-xs font-bold tracking-wide text-blue-300">
            {{ $course->code }}
        </span>

    </x-slot:headerInfo>

    <x-content-section title="Informazioni">

        <div class="grid gap-5 md:grid-cols-2">

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

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Numero docenti
                </p>

                <p class="mt-1 text-sm font-medium text-white">
                    {{ $course->teachers->count() }}
                </p>
            </div>

        </div>

    </x-content-section>

    <x-content-section
        title="Docenti"
        description="Docenti associati al corso"
    >

        <div class="grid gap-3 sm:grid-cols-2">

            @forelse ($course->teachers as $teacher)

                <div class="flex items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3">

                    <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-blue-400/20 bg-blue-500/10">

                        @if ($teacher->profile_photo_url)

                            <img
                                src="{{ $teacher->profile_photo_url }}"
                                alt="{{ $teacher->name }} {{ $teacher->surname }}"
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

    </x-content-section>

    <x-content-section
        title="Descrizione"
        description="Contenuto e obiettivi del corso"
    >

        <div class="rounded-lg border border-white/10 bg-white/5 p-4 text-sm leading-6 text-gray-300">
            {!! $course->description !!}
        </div>
        
    </x-content-section>

    <form
        method="POST"
        action="{{ route('admin.courses.destroy',$course->id) }}"
        id="delete_course"
        class="hidden"
    >
        @csrf
        @method('DELETE')
    </form>

    <x-slot:actions>

        <x-modify-button-link href="{{ route('admin.courses.edit',$course->id) }}">
            Modifica
        </x-modify-button-link>

        <x-danger-button
            type="submit"
            form="delete_course"
        >
            Elimina
        </x-danger-button>

    </x-slot:actions>

</x-show-page>