<x-layout-public>

    <x-slot:title>
        Team
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Il nostro meraviglioso Team
            </h1>

            <p class="mx-auto mt-3 max-w-2xl text-base text-gray-300">
                Scopri le persone che fanno parte del nostro gruppo di ricerca.
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="mx-auto max-w-4xl px-4 lg:px-6">

            @if ($users->isEmpty())

                <x-message-of-empty
                    title="Al momento non sono presenti membri del team"
                    image="fas fa-user"
                />

            @else

                <div class="grid gap-5 md:grid-cols-2">

                    @foreach ($users as $user)
                        @php
                            $description = $user->bio ?? null;
                        @endphp

                        <article
                            class="overflow-hidden rounded-lg border border-slate-700
                                   bg-gray-800 shadow-md transition duration-300
                                   hover:-translate-y-1
                                   hover:shadow-xl sm:h-56"
                        >
                            <a
                                href="{{ route('public.users.show', $user->id) }}"
                                class="group flex h-full flex-col sm:flex-row"
                            >
                                {{-- Immagine --}}
                                <div class="flex shrink-0 items-center justify-center p-5 sm:w-40 sm:p-4">
                                    <div
                                        class="h-28 w-28 overflow-hidden rounded-full
                                               border-2 border-slate-600 bg-slate-900
                                               shadow-md"
                                    >
                                        <img
                                            src="{{ $user->profilephotourl }}"
                                            alt="Foto di {{ $user->name }} {{ $user->surname }}"
                                            class="h-full w-full object-cover object-center"
                                        >
                                    </div>
                                </div>

                                {{-- Contenuto --}}
                                <div class="flex min-w-0 flex-1 flex-col p-4 sm:pl-0">

                                    <div>
                                        <h2 class="truncate text-xl font-bold text-white">
                                            {{ $user->name }} {{ $user->surname }}
                                        </h2>

                                        <p class="mt-1 text-sm font-medium text-amber-400">
                                            @if ($user->hasRole('admin'))
                                                Team Leader
                                            @elseif ($user->hasRole('teacher'))
                                                Docente
                                            @else
                                                Membro del Team
                                            @endif
                                        </p>

                                        @if ($description)
                                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-300">
                                                {{ strip_tags($description) }}
                                            </p>
                                        @else
                                            <p class="mt-3 text-sm italic text-gray-500">
                                                Nessuna descrizione disponibile.
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-auto pt-4">
                                        <span
                                            class="inline-flex items-center text-sm font-semibold
                                                text-amber-300 hover:text-amber-200"
                                        >
                                            Visualizza profilo

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

            @endif

        </div>
    </section>

</x-layout-public>