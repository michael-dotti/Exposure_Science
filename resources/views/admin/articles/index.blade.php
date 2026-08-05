<x-layout-menu-bar-private>
    <x-slot:title>
        Articoli
    </x-slot:title>

    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">
                Gestione articoli
            </h1>

            <p class="mt-1 text-xs text-gray-400">
                Visualizza e gestisci gli articoli presenti nel portale
            </p>
        </div>

        @can('create', App\Models\Article::class)
            <x-button-create href="/admin/articles/create">
                Nuovo Articolo
            </x-button-create>
        @endcan
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtri --}}
    <div class="mb-4 rounded-lg border border-white/10 bg-white/[0.03] px-4 py-3">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-sm font-semibold text-white">
                    Filtra gli articoli
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Filtra gli articoli per autore o per area di ricerca
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                @can('edit all articles')
                    <x-user-filter
                        title="Autore"
                        href="/admin/articles"
                        :users="$users"
                    />
                @endcan

                <x-research-area-filter
                    href="/admin/articles"
                    :researchAreas="$areas"
                />

                @if (
                    request()->filled('userId') ||
                    request()->filled('researchAreaId')
                )
                    <a
                        href="/admin/articles"
                        class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
                    >
                        Rimuovi filtri
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Elenco articoli --}}
    <div class="space-y-3">
        @forelse ($articles as $article)
            <article
                class="group relative overflow-hidden rounded-lg border border-white/10 bg-slate-800/40 shadow-sm transition duration-200 hover:border-blue-400/40 hover:bg-slate-800/60"
            >
                {{-- Link invisibile che rende cliccabile tutta la scheda --}}
                <a
                    href="/admin/articles/{{ $article->id }}"
                    class="absolute inset-0 z-10"
                    aria-label="Visualizza l'articolo {{ $article->title }}"
                ></a>

                {{-- Bordo blu laterale --}}
                <div class="pointer-events-none absolute bottom-0 left-0 top-0 w-1 bg-blue-500"></div>

                {{-- Contenuto della scheda --}}
                <div class="pointer-events-none relative z-20 flex flex-col sm:flex-row">
                    {{-- Immagine --}}
                <div class="flex items-center justify-center border-b border-white/10 bg-slate-900/30 p-4 sm:w-48 sm:flex-shrink-0 sm:border-b-0 sm:border-r">
                    <div class="flex h-36 w-full items-center justify-center overflow-hidden rounded-lg border border-blue-400/20 bg-blue-500/5">
                        @if ($article->image_path)
                            <img
                                src="{{ Storage::url($article->image_path) }}"
                                alt="{{ $article->title }}"
                                class="block max-h-full max-w-full object-contain"
                            >
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center text-center">
                                <div class="text-4xl leading-none">
                                    📄
                                </div>

                                <span class="mt-2 text-xs text-gray-400">
                                    Nessuna immagine
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                    {{-- Informazioni articolo --}}
                    <div class="min-w-0 flex-1 p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <h2 class="text-lg font-bold text-white transition group-hover:text-blue-300">
                                    {{ $article->title }}
                                </h2>

                                <div class="mt-2 flex flex-wrap items-start gap-1 text-sm">
                                    <span class="font-semibold text-blue-400">
                                        Autori:
                                    </span>

                                    <span class="text-gray-300">
                                        @forelse ($article->users as $user)
                                            {{ $user->name }}
                                            {{ $user->surname }}@if (!$loop->last), @endif
                                        @empty
                                            Nessun autore associato
                                        @endforelse
                                    </span>
                                </div>
                            </div>

                            {{-- Tipo di contenuto --}}
                            @if ($article->file_path)
                                <span class="w-fit rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
                                    Documento
                                </span>
                            @elseif ($article->external_url)
                                <span class="w-fit rounded-full border border-blue-400/20 bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-300">
                                    Link esterno
                                </span>
                            @endif
                        </div>

                        {{-- Aree di ricerca --}}
                        <div class="mt-3 flex flex-wrap gap-2">
                            @forelse ($article->researchAreas as $area)
                                <span class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-gray-300">
                                    {{ $area->name }}
                                </span>
                            @empty
                                <span class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-gray-400">
                                    Nessuna area di ricerca
                                </span>
                            @endforelse
                        </div>

                        {{-- Abstract --}}
                        <p class="mt-3 text-sm leading-5 text-gray-400">
                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($article->abstract),
                                180
                            ) }}
                        </p>

                        {{-- Pulsanti --}}
                        <div class="pointer-events-auto relative z-30 mt-4 flex flex-wrap items-center gap-2 border-t border-white/10 pt-3">
                            @canany(['update', 'delete'], $article)
                                @can('update', $article)
                                    <x-modify-button-link href="/admin/articles/{{ $article->id }}/edit">
                                        Modifica
                                    </x-modify-button-link>
                                @endcan

                                @can('delete', $article)
                                    <x-danger-button
                                        type="submit"
                                        form="delete_form_{{ $article->id }}"
                                    >
                                        Elimina
                                    </x-danger-button>

                                    <form
                                        method="POST"
                                        action="/admin/articles/{{ $article->id }}"
                                        id="delete_form_{{ $article->id }}"
                                        class="hidden"
                                    >
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                            @endcanany

                            <span class="pointer-events-none ml-0 text-xs font-semibold text-blue-400 transition group-hover:text-blue-300 sm:ml-auto">
                                Visualizza dettagli →
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <x-message-of-empty title="Nessun articolo trovato">
            </x-message-of-empty>
        @endforelse
    </div>

    {{-- Paginazione --}}
    <div class="mt-6">
        {{ $articles->links() }}
    </div>
</x-layout-menu-bar-private>