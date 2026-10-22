<x-layout-public>

    <x-slot:title>
        Novità
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Le ultime notizie
            </h1>

            <p class="mx-auto mt-3 max-w-2xl text-base text-gray-300">
                Scopri cosa c'è di nuovo.
            </p>
        </div>
    </x-slot:heading>

    <main class="my-10 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            @if ($news->isNotEmpty())

            {{-- Notizia più recente --}}
            <article class="h-105 md:h-125">
                <a
                    href="{{ route('public.news.show', $news[0]->id) }}"
                    class="group relative block h-full overflow-hidden
                        rounded-2xl border border-white/10
                        shadow-lg transition duration-300
                        hover:-translate-y-1
                        hover:border-amber-400/40
                        hover:shadow-2xl"
                >
                    {{-- Immagine --}}
                    @if ($news[0]->image_path)

                        <img
                            src="{{ Storage::url($news[0]->image_path) }}"
                            alt="Immagine della notizia {{ $news[0]->title }}"
                            class="absolute inset-0 h-full w-full
                                object-cover object-center
                                transition duration-500
                                group-hover:scale-105"
                        >

                    @else

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-gray-500">
                            <i
                                class="fa-regular fa-newspaper text-6xl"
                                aria-hidden="true"
                            ></i>

                            <span class="mt-4 text-sm font-medium">
                                Nessuna immagine
                            </span>
                        </div>

                    @endif

                    {{-- Sfumatura per rendere leggibili le scritte --}}
                    <div
                        class="absolute inset-0 bg-linear-to-t
                            from-black/90 via-black/25 to-black/10
                            transition duration-300
                            group-hover:from-black/95"
                    ></div>

                    {{-- Etichetta superiore --}}
                    <div class="absolute left-5 top-5 md:left-8 md:top-8">
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                border border-amber-400/30
                                bg-black/50 px-3 py-1.5
                                text-xs font-bold uppercase
                                tracking-wider text-amber-300
                                backdrop-blur-sm"
                        >
                            <i
                                class="fa-regular fa-newspaper"
                                aria-hidden="true"
                            ></i>

                            Ultima notizia
                        </span>
                    </div>

                    {{-- Contenuto in basso --}}
                    <div class="absolute inset-x-0 bottom-0 p-6 md:p-8">

                        {{-- Titolo --}}
                        <h2
                            class="mt-3 max-w-4xl wrap-break-word
                                text-3xl font-extrabold leading-tight
                                text-white transition-colors
                                group-hover:text-amber-300
                                md:text-4xl"
                        >
                            {{ $news[0]->title }}
                        </h2>

                        {{-- Collegamento --}}
                        <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-cyan-300">
                            <span>
                                Leggi la novità
                            </span>

                            <i
                                class="fa-solid fa-arrow-right
                                    transition-transform
                                    group-hover:translate-x-1"
                                aria-hidden="true"
                            ></i>
                        </div>

                    </div>
                </a>
            </article>

                {{-- Altre notizie --}}
                @if ($news->count() > 1)
                    <div class="mt-12">
                        <x-public-news-grid>

                            @foreach ($news->skip(1) as $n)
                                <x-news-block
                                    :n="$n"
                                    :hrefShow="route('public.news.show', $n->id)"
                                />
                            @endforeach

                        </x-public-news-grid>
                    </div>
                @endif

                {{-- Collegamento allo storico --}}
                <div class="mt-10 flex justify-center">
                    <a
                        href="{{ route('public.news.all') }}"
                        class="inline-flex items-center gap-2 rounded-lg
                               bg-blue-500 px-5 py-2.5
                               text-sm font-bold text-white
                               shadow-md transition duration-300
                               hover:-translate-y-0.5
                               hover:bg-blue-700
                               hover:shadow-lg"
                    >
                        Vedi storico notizie

                        <i
                            class="fa-solid fa-arrow-right text-xs"
                            aria-hidden="true"
                        ></i>
                    </a>
                </div>

            @else

                <x-message-of-empty
                    title="Nessuna notizia al momento"
                    image="fa-regular fa-newspaper"
                />

            @endif

        </div>
    </main>

</x-layout-public>