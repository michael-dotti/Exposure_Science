<x-show-page
    pageTitle="Dettaglio Articolo"
    heading="Dati dell'articolo"
    :backHref="route('admin.articles.index')"
    :title="$article->title"
>

    <x-slot:icon>
        <i class="fa-regular fa-file text-white"></i>
    </x-slot:icon>

    <x-content-section title="Informazioni">

        <div class="grid gap-5 sm:grid-cols-2">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Data pubblicazione
                </p>

                <p class="mt-1 text-sm font-medium text-white">
                    {{ \Carbon\Carbon::parse($article->data_pubblicazione)->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Visualizzazione
                </p>

                <p class="mt-1 text-sm font-medium text-white">
                    @if ($article->document)
                        Scaricabile
                    @else
                        Articolo acquistabile online
                    @endif
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Numero autori
                </p>

                <p class="mt-1 text-sm font-medium text-white">
                    {{ $article->users->count() }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Numero aree di ricerca
                </p>

                <p class="mt-1 text-sm font-medium text-white">
                    {{ $article->researchAreas->count() }}
                </p>
            </div>

        </div>

    </x-content-section>

    <x-content-section
        title="Autori"
        description="Autori associati all'articolo"
    >

        <div class="grid gap-3 sm:grid-cols-2">

            @forelse ($article->users as $user)

                <div class="flex items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-4 py-3">

                    <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-blue-400/20 bg-blue-500/10">

                        @if ($user->profilephotourl)

                            <img
                                src="{{ $user->profilephotourl }}"
                                alt="{{ $user->name }} {{ $user->surname }}"
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

                        @if ($user->email)

                            <p class="truncate text-xs text-gray-400">
                                {{ $user->email }}
                            </p>

                        @endif

                    </div>

                </div>

            @empty

                <div class="rounded-lg border border-white/10 bg-white/5 px-4 py-3 sm:col-span-2">

                    <p class="text-sm text-gray-400">
                        Nessun autore associato.
                    </p>

                </div>

            @endforelse

        </div>

    </x-content-section>

    <x-content-section
        title="Aree di ricerca"
        description="Aree associate all'articolo"
    >

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

    </x-content-section>

    <x-content-section
        title="Abstract"
        description="Sintesi del contenuto dell'articolo"
    >

        <div class="flex flex-col gap-5 md:flex-row md:items-start">

            @if ($article->image_path)

                <div class="w-full shrink-0 md:w-48">

                    <div class="overflow-hidden rounded-lg border border-white/10 bg-white/5 p-3">

                        <img
                            src="{{ Storage::url($article->image_path) }}"
                            alt="{{ $article->title }}"
                            class="block h-auto w-full rounded-md"
                        >

                    </div>

                </div>

            @endif

            <div class="min-w-0 flex-1">

                <div class="overflow-hidden rounded-lg border border-white/10 bg-white/5">

                    <div class="p-4 text-sm leading-6 wrap-break-word text-gray-300">
                        {!! $article->abstract !!}
                    </div>

                    @if ($article->document || $article->external_url)

                        <div class="flex flex-col gap-3 border-t border-white/10 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">

                            <span class="text-xs text-gray-400">
                                Consulta l'articolo
                            </span>

                            @if ($article->document)

                                <x-button-download-file
                                    :file="$article->document"
                                />

                            @elseif ($article->external_url)

                                <a
                                    href="{{ $article->external_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-md border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-300 transition hover:bg-blue-500/20"
                                >
                                    Apri articolo
                                </a>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </x-content-section>

    <form
        method="POST"
        action="{{ route('admin.articles.destroy', $article) }}"
        id="delete_article"
        class="hidden"
    >
        @csrf
        @method('DELETE')
    </form>

    <x-slot:actions>
        <x-modify-button-link href="{{ route('admin.articles.edit', $article) }}">
            Modifica
        </x-modify-button-link>

        <x-danger-button
            type="submit"
            form="delete_article"
        >
            Elimina
        </x-danger-button>
    </x-slot:actions>

</x-show-page>