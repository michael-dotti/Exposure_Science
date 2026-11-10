<x-layout-public>
    <x-slot:title>
        Pubblicazioni
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Le nostre pubblicazioni
            </h1>

            <p class="mx-auto mt-3 max-w-2xl text-base text-gray-300">
                Scopri come la scienza avanza ogni giorno.
            </p>
        </div>
    </x-slot:heading>


    <main class="relative z-10 my-6 text-white">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Filtri -->
            <x-filter-box
                variant="public"
                title="Filtra le pubblicazioni"
                description="Seleziona un autore o un’area di ricerca per restringere i risultati"
                reset-url="{{ route('public.articles.index') }}"
                :active-filters="$currentFilters"
            >
                <x-user-filter
                    title="Autore"
                    href="/public/articles"
                    :users="$users"
                />

                <x-research-area-filter
                    href="/public/articles"
                    :researchAreas="$areas"
                />
            </x-filter-box>


            @if ($articles->isEmpty())

                <!-- Nessun risultato -->
                <div class="rounded-2xl bg-gray-800/60 p-8 shadow-xl">
                    <x-message-of-empty
                        title="Nessun articolo trovato"
                    />
                </div>

            @else

                <!-- Elenco pubblicazioni -->
                <section
                    class="grid grid-cols-1 items-stretch gap-6
                           md:grid-cols-2 xl:grid-cols-3"
                >
                    @foreach ($articles as $article)
                        @php
                            /*
                             * Quill salva l'abstract come HTML.
                             * Sostituiamo i tag con spazi, decodifichiamo
                             * le entità e normalizziamo gli spazi.
                             */
                            $abstractPulito = preg_replace(
                                '/<[^>]+>/u',
                                ' ',
                                $article->abstract ?? ''
                            );

                            $abstractPulito = html_entity_decode(
                                $abstractPulito,
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            );

                            $abstractPulito = preg_replace(
                                '/\s+/u',
                                ' ',
                                trim($abstractPulito)
                            );

                            $abstractBreve = \Illuminate\Support\Str::limit(
                                $abstractPulito,
                                180
                            );
                        @endphp


                        <article class="h-full min-w-0">
                            <a
                                href="{{ route('public.articles.show', $article->id) }}"
                                class="group flex h-full min-w-0 flex-col
                                       overflow-hidden rounded-2xl bg-gray-800
                                       shadow-lg ring-1 ring-white/5
                                       transition duration-300
                                       hover:-translate-y-1
                                       hover:bg-gray-700
                                       hover:shadow-2xl
                                       hover:ring-amber-400/40"
                            >

                                <!-- Immagine -->
                                <div
                                    class="relative h-48 w-full shrink-0
                                           overflow-hidden bg-gray-900"
                                >
                                    
                                    <img
                                        src="{{ Storage::url($article->image_path) }}"
                                        alt="Immagine della pubblicazione {{ $article->title }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover
                                                transition duration-500
                                                group-hover:scale-105"
                                    />
                                </div>


                                <!-- Contenuto della card -->
                                <div class="flex min-w-0 flex-1 flex-col p-6">

                                    <!-- Titolo -->
                                    <h2
                                        class="line-clamp-2 min-h-14
                                               text-xl font-bold
                                               leading-7 text-white
                                               transition-colors
                                               group-hover:text-amber-300"
                                    >
                                        {{ $article->title }}
                                    </h2>


                                    <!-- Abstract -->
                                    <div
                                        class="mt-3 min-h-18 min-w-0
                                        class="mt-3 min-h-18 min-w-0
                                               text-sm leading-6 text-gray-300"
                                    >
                                        @if ($abstractBreve)
                                            <p
                                                class="line-clamp-3 wrap-break-word"
                                            >
                                                {{ $abstractBreve }}
                                            </p>
                                        @else
                                            <p class="italic text-gray-500">
                                                Nessuna descrizione disponibile.
                                            </p>
                                        @endif
                                    </div>


                                    <!-- Autori e aree -->
                                    <div
                                        class="mt-auto min-w-0 space-y-4
                                               border-t border-gray-700 pt-5"
                                    >

                                        <!-- Autori -->
                                        <div class="flex min-w-0 items-start gap-3">
                                            <span
                                                class="flex h-9 w-9 shrink-0
                                                       items-center justify-center
                                                       rounded-lg bg-cyan-500/10
                                                       text-cyan-400"
                                            >
                                                <i
                                                    class="fa-solid fa-user-group"
                                                    aria-hidden="true"
                                                ></i>
                                            </span>

                                            <div class="min-w-0">
                                                <p
                                                    class="text-xs font-bold uppercase
                                                           tracking-wide text-gray-500"
                                                >
                                                    {{ $article->users->count() === 1
                                                        ? 'Autore:'
                                                        : 'Autori:' }}
                                                </p>

                                                <p
                                                    class="mt-1 line-clamp-2
                                                           wrap-break-word text-sm
                                                           font-medium text-gray-200"
                                                >
                                                    @forelse ($article->users as $user)
                                                        {{ $user->name }} {{ $user->surname }}@if (! $loop->last), @endif
                                                    @empty
                                                        Non specificato
                                                    @endforelse
                                                </p>
                                            </div>
                                        </div>


                                        <!-- Aree di ricerca -->
                                        <div class="flex min-w-0 items-start gap-3">
                                            <span
                                                class="flex h-9 w-9 shrink-0
                                                       items-center justify-center
                                                       rounded-lg bg-amber-400/10
                                                       text-amber-400"
                                            >
                                                <i
                                                    class="fa-solid fa-flask"
                                                    aria-hidden="true"
                                                ></i>
                                            </span>

                                            <div class="min-w-0">
                                                <p
                                                    class="text-xs font-bold uppercase
                                                           tracking-wide text-gray-500"
                                                >
                                                    Aree di ricerca
                                                </p>

                                                <p
                                                    class="mt-1 line-clamp-2
                                                           wrap-break-word text-sm
                                                           font-medium text-gray-200"
                                                >
                                                    @if ($article->researchAreas->isNotEmpty())
                                                        {{ $article->researchAreas->pluck('name')->join(', ') }}
                                                    @else
                                                        Non specificate
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- Link finale -->
                                    <div
                                        class="mt-5 flex items-center justify-end
                                               gap-2 text-sm font-semibold
                                               text-cyan-400"
                                    >
                                        <span>Leggi la pubblicazione</span>

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
                    @endforeach
                </section>


                <!-- Paginazione -->
                <div class="mt-9">
                    {{ $articles->links() }}
                </div>

            @endif

        </div>
    </main>
</x-layout-public>