<x-layout-public>

    <x-slot:title>
        {{ $article->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-amber-300">
                {{ $article->title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante indietro --}}
        <div class="mb-8">
            <x-public-button-back
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

                            <span class="wrap-break-word font-medium text-gray-200">
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

                            <span class="wrap-break-word font-medium text-gray-200">
                                {{ $article->researchAreas
                                    ->pluck('name')
                                    ->join(', ') ?: 'Non indicate' }}
                            </span>
                        </div>

                    </div>

                    {{-- IMMAGINE VERSIONE MOBILE --}}
                    {{-- Mostrata solo su schermi piccoli. Nascosta da lg in su (lg:hidden) --}}
                    <div class="mt-6 flex items-center justify-center rounded-xl border border-white/10 bg-gray-900/50 p-4 lg:hidden">
                        <img
                            src="{{ Storage::url($article->image_path) }}"
                            alt="Immagine della pubblicazione {{ $article->title }}"
                            class="max-h-72 w-full rounded-xl object-contain shadow-lg"
                        >
                    </div>

                    {{-- Testo dell’Abstract --}}
                    <div class="mt-6">
                        <div class="article-content wrap-anywhere">
                            {!! $article->abstract !!}
                        </div>
                    </div>

                </section>

                {{-- IMMAGINE VERSIONE DESKTOP --}}
                {{-- Nascosta su mobile (hidden). Mostrata come flexbox da lg in su (lg:flex) --}}
                <section
                    class="hidden lg:flex min-h-72 items-center justify-center
                           border-t border-white/10
                           bg-gray-900/50 p-6
                           lg:border-l lg:border-t-0 lg:p-8"
                >

                    <img
                        src="{{ Storage::url($article->image_path) }}"
                        alt="Immagine della pubblicazione {{ $article->title }}"
                        class="max-h-97.5 w-full rounded-xl object-contain shadow-lg"
                    >

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

                        @else

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
                        @endif

                    </div>

                </div>

            </section>

        </article>

    </main>
</x-layout-public>