<x-layout-public>
    <x-slot:title>
        {{ $user->name }} {{ $user->surname }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">

            <h1 class="wrap-break-word text-3xl font-bold leading-tight text-amber-300">
                {{ $user->name }} {{ $user->surname }}
            </h1>

            <p class="mt-2 text-base text-gray-300">
                @if ($user->hasRole('admin'))
                    Team Leader
                @elseif ($user->hasRole('teacher'))
                    Docente
                @else
                    Membro del Team
                @endif
            </p>

        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante fuori dalla scheda --}}
        <div class="mb-8">
            <x-public-botton-back
                title="Torna al team"
                :href="route('public.users.index')"
            />
        </div>

        <article class="overflow-hidden rounded-2xl border border-white/10 bg-gray-800 shadow-2xl">

            {{-- Profilo --}}
            <section class="grid grid-cols-1 items-center gap-8 p-7 sm:p-9 lg:grid-cols-[minmax(0,1fr)_220px] lg:p-12">

                <div class="min-w-0 lg:pr-6">

                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.22em] text-gray-400">
                            Descrizione
                        </p>

                        <p class="max-w-3xl wrap-break-word text-base font-medium leading-7 text-gray-100">
                            {{ $user->bio ?: 'Nessuna descrizione disponibile.' }}
                        </p>
                    </div>

                </div>

                {{-- Foto --}}
                <div class="flex justify-center lg:justify-end">
                    <div class="shrink-0">
                        <img
                            src="{{ $user->profilePhotoUrl }}"
                            alt="Foto di {{ $user->name }} {{ $user->surname }}"
                            class="h-48 w-48 rounded-full object-cover shadow-xl"
                        >
                    </div>
                </div>

            </section>

            {{-- Corsi insegnati --}}
            <section class="border-t border-white/10 bg-gray-900/40 px-6 py-5 sm:px-8">

                {{-- Intestazione compatta --}}
                <div class="mb-4 flex items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-cyan-500/10 text-sm text-cyan-400">
                        <i
                            class="fa-solid fa-graduation-cap"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <h2 class="text-base font-bold text-white">
                        Corsi insegnati
                    </h2>
                </div>

                {{-- Elenco dei corsi --}}
                @if ($user->courses->isNotEmpty())
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                        @foreach ($user->courses as $course)
                            <a
                                href="{{ route('public.courses.show', $course) }}"
                                title="Visualizza il corso {{ $course->title }}"
                                class="group flex min-w-0 items-center gap-3
                                    rounded-xl border border-white/10
                                    bg-gray-800 px-4 py-3
                                    transition
                                    hover:-translate-y-0.5
                                    hover:border-cyan-400/30
                                    hover:bg-gray-700"
                            >
                                {{-- Icona --}}
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-cyan-500/10 text-sm text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                                    <i
                                        class="fa-solid fa-book-open"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                {{-- Titolo e codice --}}
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-semibold text-white">
                                        {{ $course->title }}
                                    </span>

                                    <span class="mt-0.5 block truncate text-[11px] text-gray-400">
                                        {{ $course->code }}
                                    </span>
                                </span>

                                {{-- Freccia --}}
                                <i
                                    class="fa-solid fa-chevron-right shrink-0
                                        text-2xs text-gray-500 transition
                                        group-hover:translate-x-0.5
                                        group-hover:text-cyan-400"
                                    aria-hidden="true"
                                ></i>
                            </a>
                        @endforeach

                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-white/10 bg-gray-800/50 px-4 py-4 text-center">
                        <p class="text-sm italic text-gray-400">
                            Nessun corso associato.
                        </p>
                    </div>
                @endif

            </section>


            {{-- Contatti e curriculum --}}
            <section class="border-t border-white/10 bg-gray-900/60 p-5 sm:p-6">

                <div
                    @class([
                        'grid grid-cols-1 items-stretch gap-5',
                        'md:grid-cols-2' => $user->curriculum,
                    ])
                >
                    {{-- Contatti --}}
                    <section class="flex h-full flex-col rounded-xl border border-white/5 bg-gray-800 p-6 shadow-lg">

                        <h2 class="mb-5 text-lg font-bold uppercase tracking-wide text-white">
                            Contatti
                        </h2>

                        <div class="flex flex-1 flex-col gap-3">

                            <a
                                href="mailto:{{ $user->email }}"
                                class="group flex min-w-0 items-center gap-4 rounded-xl bg-gray-900/50 p-4 transition hover:bg-gray-900"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-500/15 text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                                    <i
                                        class="fa-regular fa-envelope"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                <span class="min-w-0">
                                    <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">
                                        E-mail
                                    </span>

                                    <span class="mt-1 block break-all font-semibold text-gray-100 group-hover:text-cyan-400">
                                        {{ $user->email }}
                                    </span>
                                </span>
                            </a>

                            @if ($user->website)
                                <a
                                    href="{{ $user->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group flex min-w-0 items-center gap-4 rounded-xl bg-gray-900/50 p-4 transition hover:bg-gray-900"
                                >
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-500/15 text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                                        <i
                                            class="fa-solid fa-globe"
                                            aria-hidden="true"
                                        ></i>
                                    </span>

                                    <span class="min-w-0">
                                        <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">
                                            Sito web
                                        </span>

                                        <span class="mt-1 block break-all font-semibold text-gray-100 group-hover:text-cyan-400">
                                            {{ $user->website }}
                                        </span>
                                    </span>
                                </a>
                            @endif

                        </div>
                    </section>

                    {{-- Curriculum --}}
                    @if ($user->curriculum)
                        <section class="flex h-full flex-col rounded-xl border border-white/5 bg-gray-800 p-6 shadow-lg">

                            <h2 class="mb-5 text-lg font-bold uppercase tracking-wide text-white">
                                Curriculum Vitae
                            </h2>

                            <div class="flex flex-1 items-center rounded-xl bg-gray-900/50 px-5 py-5">

                                <div class="grid w-full grid-cols-1 items-center gap-5 sm:grid-cols-[52px_minmax(0,1fr)_auto]">

                                    <div class="mx-auto flex h-13 w-13 items-center justify-center rounded-xl bg-amber-400/15 text-xl text-amber-400 sm:mx-0">
                                        <i
                                            class="fa-regular fa-file-lines"
                                            aria-hidden="true"
                                        ></i>
                                    </div>

                                    <p class="min-w-0 text-center text-sm font-medium leading-6 text-gray-200 sm:text-left">
                                        Curriculum di

                                        <span class="block wrap-break-word font-bold text-white">
                                            {{ $user->name }} {{ $user->surname }}
                                        </span>
                                    </p>

                                    <a
                                        href="{{ route('files.show', $user->curriculum->id) }}"
                                        title="{{ $user->curriculum->file_name }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mx-auto inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 sm:mx-0"
                                    >
                                        <i
                                            class="fa-solid fa-arrow-up-right-from-square"
                                            aria-hidden="true"
                                        ></i>

                                        Apri
                                    </a>

                                </div>
                            </div>
                        </section>
                    @endif

                </div>
            </section>

        </article>
    </main>
</x-layout-public>