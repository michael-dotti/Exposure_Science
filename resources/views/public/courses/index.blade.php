<x-layout-public>
    <x-slot:title>
        Corsi
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                I nostri corsi
            </h1>

            <p class="max-w-2xl mx-auto mt-3 text-base text-gray-300">
                Scopri i corsi offerti dal nostro gruppo di ricerca.
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="max-w-4xl px-4 mx-auto lg:px-6">

            @if ($courses->isEmpty())
                <x-message-of-empty title="Al Momento Non Sono Presenti Corsi" image="fa-solid fa-person-chalkboard" />
            @else
                <div class="grid gap-5 md:grid-cols-2">

                    @foreach ($courses as $course)
                        <article
                            class="overflow-hidden rounded-lg border border-slate-700
                                   bg-gray-800 shadow-md transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <a
                                href="/public/courses/{{ $course->id }}"
                                class="flex flex-col h-full"
                            >
                                <div class="flex flex-col justify-between flex-1 p-4">

                                    <div>
                                        <h2 class="text-xl font-bold text-white">
                                            {{ $course->title }}
                                        </h2>

                                        <p class="mt-1 text-sm font-medium text-amber-400">
                                            Codice corso: {{ $course->code }}
                                        </p>

                                        <div class="grid grid-cols-2 gap-2 mt-4 text-sm text-gray-300">

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Lingua:
                                                </span>

                                                {{ $course->language }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Crediti:
                                                </span>

                                                {{ $course->points }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Semestre:
                                                </span>

                                                {{ $course->semester }}
                                            </p>

                                            <p>
                                                <span class="font-semibold text-white">
                                                    Durata:
                                                </span>

                                                {{ $course->duration }} ore
                                            </p>

                                        </div>

                                        @if ($course->description)
                                            <p class="mt-4 text-sm leading-6 text-gray-300">
                                                {{ \Illuminate\Support\Str::limit(
                                                    strip_tags($course->description),
                                                    120
                                                ) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <span
                                            class="inline-flex items-center text-sm font-semibold
                                                   text-amber-300 hover:text-amber-200"
                                        >
                                            Visualizza corso

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