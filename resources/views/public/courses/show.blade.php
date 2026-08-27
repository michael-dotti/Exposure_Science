<x-layout-public>
    <x-slot:title>
        {{ $course->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                {{ $course->title }}
            </h1>

            <p class="mt-2 text-base text-gray-300">
                Codice corso: {{ $course->code }}
            </p>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="max-w-4xl px-4 mx-auto lg:px-6">

            <article
                class="overflow-hidden border rounded-lg shadow-md
                       border-slate-700 bg-gray-800"
            >
                <div class="p-6">

                    <div class="grid gap-5 md:grid-cols-2">

                        <div>
                            <p class="text-sm text-gray-400">
                                Lingua
                            </p>

                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $course->language }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">
                                Codice
                            </p>

                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $course->code }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">
                                Crediti
                            </p>

                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $course->points }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">
                                Semestre
                            </p>

                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $course->semester }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">
                                Durata
                            </p>

                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $course->duration }} ore
                            </p>
                        </div>

                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-700">
                        <h2 class="text-xl font-bold text-amber-300">
                            Descrizione del corso
                        </h2>

                        @if ($course->description)
                            <p class="mt-3 leading-7 text-gray-300">
                                {{ $course->description }}
                            </p>
                        @else
                            <p class="mt-3 text-gray-400">
                                Nessuna descrizione disponibile.
                            </p>
                        @endif
                    </div>

                    <div class="mt-8">
                        <x-public-botton-back title="Torna ai corsi" :href="route('public.courses.index')" />
                    </div>

                </div>
            </article>

        </div>
    </section>
</x-layout-public>