<x-layout-private>
    <x-slot:title>
        Dettaglio Articolo
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        {{-- Intestazione pagina --}}
        <div class="mb-6 mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Dati dell'articolo
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Visualizza le informazioni di {{ $article->title }}
                </p>
            </div>

            <x-link-button href="/admin/articles">
                Indietro
            </x-link-button>
        </div>

        {{-- Testata articolo --}}
        <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="flex items-center gap-4 p-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                    <i class="fa-regular fa-file text-white"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-base font-semibold text-white">
                        {{ $article->title }}
                    </h2>

                    <div class="mt-1 flex flex-wrap items-center gap-2">
                        @if ($article->document)
                            <span class="rounded-md border border-green-400/20 bg-green-500/10 px-2 py-1 text-xs font-semibold text-green-300">
                                Documento disponibile
                            </span>
                        @else
                            <span class="rounded-md border border-blue-400/20 bg-blue-500/10 px-2 py-1 text-xs font-semibold text-blue-300">
                                Link esterno
                            </span>
                        @endif

                        <span class="text-xs text-gray-400">
                            Informazioni generali dell'articolo
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informazioni principali --}}
        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="mb-5 text-base font-semibold text-white">
                    Informazioni
                </h2>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Titolo
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            {{ $article->title }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Tipo di contenuto
                        </p>

                        <p class="mt-1 text-sm font-medium text-white">
                            @if ($article->document)
                                Documento
                            @else
                                Link esterno
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Abstract e immagine --}}
        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Abstract
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Sintesi del contenuto dell'articolo
                </p>

                <div class="grid gap-5 md:grid-cols-3">
                    <div class="{{ $article->image_path ? 'md:col-span-2' : 'md:col-span-3' }}">
                        <div class="rounded-lg border border-white/10 bg-white/5 p-4 text-sm leading-6 text-gray-300">
                            {!! $article->abstract !!}
                        </div>
                    </div>

                    @if ($article->image_path)
                        <div class="flex items-center justify-center rounded-lg border border-white/10 bg-white/5 p-3">
                            <img
                                src="{{ Storage::url($article->image_path) }}"
                                alt="{{ $article->title }}"
                                class="max-h-64 w-full rounded-md object-contain"
                            >
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Autori --}}
        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Autori dell'articolo
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Elenco degli autori associati all'articolo
                </p>

                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($article->users as $user)
                        <div class="flex items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3">
                        <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-blue-400/20 bg-blue-500/10">
                            @if ($user->profilephotourl)
                                <img
                                    src="{{ $user->profilephotourl }}"
                                    alt="Foto profilo di {{ $user->name }} {{ $user->surname }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-blue-300">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                    {{ strtoupper(substr($user->surname, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-white">
                                    {{ $user->name }} {{ $user->surname }}
                                </p>

                                <p class="truncate text-xs text-gray-400">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-white/10 bg-white/5 px-4 py-3 sm:col-span-2">
                            <p class="text-sm text-gray-400">
                                Nessun autore associato all'articolo.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Aree di ricerca --}}
        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Aree di ricerca
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Argomenti e aree associate all'articolo
                </p>

                <div class="flex flex-wrap gap-2">
                    @forelse ($article->researchAreas as $area)
                        <span class="rounded-md border border-blue-400/20 bg-blue-500/10 px-3 py-2 text-sm font-medium text-blue-300">
                            {{ $area->name }}
                        </span>
                    @empty
                        <div class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3">
                            <p class="text-sm text-gray-400">
                                Nessuna area di ricerca associata.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Documento o link --}}
        <div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="p-5">
                <h2 class="text-base font-semibold text-white">
                    Articolo completo
                </h2>

                <p class="mb-3 mt-1 text-xs text-gray-400">
                    Consulta o scarica il contenuto completo dell'articolo
                </p>

                @if ($article->document)
                    <div class="flex flex-col gap-3 rounded-lg border border-white/10 bg-white/5 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-green-400/20 bg-green-500/10 text-xl">
                                📎
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-medium text-white">
                                    Documento dell'articolo
                                </p>

                                
                            </div>
                        </div>

                        
                        <div class="mb-6">
                            <x-button-download-file :file="$article->document" text="Scarica l'articolo scientifico:"/>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col gap-3 rounded-lg border border-white/10 bg-white/5 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm font-medium text-white">
                                Link esterno
                        </p>

                        <a
                            href="{{ $article->external_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex shrink-0 items-center justify-center rounded-md border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-300 transition hover:bg-blue-500/20"
                        >
                            Apri articolo
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form eliminazione --}}
        <form
            method="POST"
            action="{{ route('admin.articles.destroy',$article->id) }}"
            id="delete_article"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>

        {{-- Pulsanti --}}
        @canany(['update', 'delete'], $article)
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-white/10 py-5">
                @can('update', $article)
                    <x-modify-button-link href="{{ route('admin.articles.edit',$article->id) }}">
                        Modifica
                    </x-modify-button-link>
                @endcan

                @can('delete', $article)
                    <x-danger-button
                        type="submit"
                        form="delete_article"
                    >
                        Elimina
                    </x-danger-button>
                @endcan
            </div>
        @endcanany
    </div>
</x-layout-private>