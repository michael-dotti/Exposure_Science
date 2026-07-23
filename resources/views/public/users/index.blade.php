<x-layout-public>
    <x-slot:title>
        Team
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Il nostro meraviglioso Team
            </h1>

            <p class="max-w-2xl mx-auto mt-3 text-base text-gray-300">
                Scopri le persone che fanno parte del nostro gruppo di ricerca.
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="max-w-4xl px-4 mx-auto lg:px-6">

            @if ($users->isEmpty())
                <div class="py-10 text-center">
                    <p class="text-base text-gray-300">
                        Al momento non sono presenti membri del team.
                    </p>
                </div>
            @else
                <div class="grid gap-5 md:grid-cols-2">

                    @foreach ($users as $user)
                        @php
                            $description = $user->bio ?? null;
                        @endphp

                        <article
                            class="overflow-hidden rounded-lg border border-slate-700
                                   bg-gray-800 shadow-md transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <a
                                href="/public/users/{{ $user->id }}"
                                class="flex flex-col h-full sm:flex-row"
                            >
                                <div class="w-full sm:w-32 shrink-0">
                                    <img
                                        src="{{ $user->profilephotourl }}"
                                        alt="Foto di {{ $user->name }} {{ $user->surname }}"
                                        class="w-full h-40 sm:h-full object-cover"
                                    >
                                </div>

                                <div class="flex flex-col justify-between flex-1 p-3">

                                    <div>
                                        <h2 class="text-xl font-bold text-white">
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
                                            <p class="mt-3 text-sm leading-6 text-gray-300">
                                                {{ \Illuminate\Support\Str::limit(
                                                    strip_tags($description),
                                                    85
                                                ) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <span
                                            class="inline-flex items-center text-sm font-semibold
                                                   text-amber-300 hover:text-amber-200"
                                        >
                                            Visualizza profilo

                                            <svg
                                                class="w-4 h-4 ml-2"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
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