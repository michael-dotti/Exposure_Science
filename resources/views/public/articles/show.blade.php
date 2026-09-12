<x-layout-public>

    <x-slot:title>
        {{ $article->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">
            <h1 class="break-words text-3xl font-bold leading-tight text-amber-300">
                {{ $article->title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante indietro --}}
        <div class="mb-8">
            <x-public-botton-back
                title="Torna agli articoli"
                :href="route('public.articles.index')"
            />
        </div>

        {{-- Scheda articolo --}}
        <article class="overflow-hidden rounded-2xl border border-white/10 bg-gray-800 shadow-2xl">

            {{-- Abstract e immagine --}}
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_400px]">

                {{-- Abstract --}}
                <section class="min-w-0 p-6 sm:p-8 lg:p-10">

                    {{-- Titolo della sezione --}}
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-amber-400/20 bg-amber-400/10 text-amber-300">
                            <i
                                class="fa-solid fa-align-left"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <h2 class="text-xl font-bold text-white">
                            Abstract
                        </h2>
                    </div>

                    {{-- Autori e aree di ricerca --}}
                    <div class="mt-6 flex flex-col gap-3 border-b border-white/10 pb-6">

                        {{-- Autori --}}
                        <div class="flex min-w-0 items-start gap-2 text-sm">
                            <i
                                class="fa-solid fa-user-group mt-1 shrink-0 text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            <span class="shrink-0 font-semibold text-gray-400">
                                {{ $article->users->count() === 1
                                    ? 'Autore:'
                                    : 'Autori:' }}
                            </span>

                            <span class="break-words font-medium text-gray-200 [overflow-wrap:anywhere]">
                                @forelse ($article->users as $user)
                                    {{ $user->name }}
                                    {{ $user->surname }}@if (!$loop->last), @endif
                                @empty
                                    Non indicato
                                @endforelse
                            </span>
                        </div>

                        {{-- Aree di ricerca --}}
                        <div class="flex min-w-0 items-start gap-2 text-sm">
                            <i
                                class="fa-solid fa-flask mt-1 shrink-0 text-amber-300"
                                aria-hidden="true"
                            ></i>

                            <span class="shrink-0 font-semibold text-gray-400">
                                {{ $article->researchAreas->count() === 1
                                    ? 'Area di ricerca:'
                                    : 'Aree di ricerca:' }}
                            </span>

                            <span class="break-words font-medium text-gray-200 [overflow-wrap:anywhere]">
                                {{ $article->researchAreas
                                    ->pluck('name')
                                    ->join(', ') ?: 'Non indicate' }}
                            </span>
                        </div>

                    </div>

                    {{-- Testo dell’Abstract --}}
                    <div class="mt-6">
                        <div class="article-content [overflow-wrap:anywhere]">
                            {!! $article->abstract !!}
                        </div>
                    </div>

                </section>

                {{-- Immagine --}}
                <section
                    class="flex min-h-72 items-center justify-center
                           border-t border-white/10
                           bg-gray-900/50 p-6
                           lg:border-l lg:border-t-0 lg:p-8"
                >

                    @if ($article->image_path)

                        <img
                            src="{{ Storage::url($article->image_path) }}"
                            alt="Immagine della pubblicazione {{ $article->title }}"
                            class="max-h-97.5 w-full rounded-xl object-contain shadow-lg"
                        >

                    @else

                        <div
                            class="flex min-h-64 w-full flex-col
                                   items-center justify-center rounded-xl
                                   border border-dashed border-white/10
                                   bg-white/3 px-6 text-center"
                        >
                            <span
                                class="flex h-16 w-16 items-center
                                       justify-center rounded-2xl
                                       bg-amber-400/10
                                       text-2xl text-amber-300"
                            >
                                <i
                                    class="fa-regular fa-image"
                                    aria-hidden="true"
                                ></i>
                            </span>

                            <p class="mt-4 font-medium text-gray-400">
                                Immagine non disponibile
                            </p>
                        </div>

                    @endif

                </section>

            </div>

            {{-- Ottenimento articolo --}}
            <section class="border-t border-white/10 bg-gray-900/60 p-6 sm:p-8">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="min-w-0">

                        <h2 class="flex items-center gap-3 text-lg font-bold text-white">
                            <i
                                class="fa-solid fa-file-lines text-cyan-400"
                                aria-hidden="true"
                            ></i>

                            Ottieni l’articolo
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            @if ($article->document)
                                Scarica il documento completo della pubblicazione.
                            @elseif ($article->external_url)
                                Consulta la pubblicazione sul sito esterno.
                            @else
                                Il documento completo non è attualmente disponibile.
                            @endif
                        </p>

                    </div>

                    <div class="shrink-0">

                        @if ($article->document)

                            <x-button-download-file
                                :file="$article->document"
                                text=""
                            />

                        @elseif ($article->external_url)

                            <a
                                href="{{ $article->external_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                title="Apri la pubblicazione in una nuova scheda"
                                class="inline-flex min-h-11 items-center
                                       justify-center gap-2 rounded-lg
                                       bg-cyan-500 px-5 py-3
                                       text-sm font-bold text-white
                                       shadow-lg shadow-cyan-950/30
                                       transition
                                       hover:-translate-y-0.5
                                       hover:bg-cyan-400
                                       focus:outline-none
                                       focus:ring-2 focus:ring-cyan-300
                                       focus:ring-offset-2
                                       focus:ring-offset-gray-900"
                            >
                                <i
                                    class="fa-solid fa-arrow-up-right-from-square"
                                    aria-hidden="true"
                                ></i>

                                Leggi l’articolo
                            </a>

                        @else

                            <span
                                class="inline-flex items-center gap-2
                                       rounded-lg border border-white/10
                                       bg-white/5 px-4 py-3
                                       text-sm text-gray-400"
                            >
                                <i
                                    class="fa-solid fa-circle-info"
                                    aria-hidden="true"
                                ></i>

                                Non disponibile
                            </span>

                        @endif

                    </div>

                </div>

            </section>

        </article>

    </main>

    <style>
        /*
         * Visualizzazione pubblica del contenuto creato con Quill.
         */
        .article-content {
            width: 100%;
            max-width: 100%;
            color: rgb(229 231 235);
            font-size: 1rem;
            line-height: 1.8;
            text-align: left;
            overflow-wrap: anywhere;
            word-break: normal;
            white-space: normal;
        }

        .article-content * {
            max-width: 100%;
        }

        .article-content p {
            margin: 0 0 1rem;
            padding: 0;
            color: rgb(229 231 235) !important;
            text-align: left !important;
            text-indent: 0;
            white-space: normal;
        }

        .article-content p:last-child {
            margin-bottom: 0;
        }

        .article-content h1 {
            margin: 1.5rem 0 1rem;
            color: rgb(255 255 255) !important;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .article-content h2 {
            margin: 1.25rem 0 0.75rem;
            color: rgb(255 255 255) !important;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .article-content h3 {
            margin: 1rem 0 0.75rem;
            color: rgb(255 255 255) !important;
            font-size: 1.125rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .article-content strong,
        .article-content b {
            color: rgb(255 255 255);
            font-weight: 700;
        }

        .article-content em,
        .article-content i {
            font-style: italic;
        }

        .article-content ul {
            margin: 1rem 0;
            padding-left: 1.5rem;
            color: rgb(229 231 235);
            list-style-type: disc;
        }

        .article-content ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
            color: rgb(229 231 235);
            list-style-type: decimal;
        }

        .article-content li {
            margin-bottom: 0.25rem;
            color: rgb(229 231 235);
        }

        .article-content blockquote {
            margin: 1rem 0;
            padding-left: 1rem;
            border-left: 4px solid rgba(252, 211, 77, 0.5);
            color: rgb(209 213 219);
        }

        .article-content a {
            color: rgb(34 211 238) !important;
            text-decoration: underline;
            text-underline-offset: 3px;
            overflow-wrap: anywhere;
        }

        .article-content pre {
            max-width: 100%;
            margin: 1rem 0;
            padding: 1rem;
            overflow-x: auto;
            border-radius: 0.5rem;
            background-color: rgb(17 24 39);
            color: rgb(229 231 235);
            white-space: pre-wrap;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
    </style>

</x-layout-public>