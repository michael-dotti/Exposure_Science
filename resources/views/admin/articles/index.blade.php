<x-layout-private>
    <x-slot:title>
        Articoli
    </x-slot:title>

    <x-dashboard-index-header
        title="Gestione Articoli"
        subtitle="Visualizza e gestisci gli articoli presenti nel portale"
    >
        <x-slot:actions>
            @can('create', App\Models\Article::class)
                <x-button-create href="{{ route('admin.articles.create') }}">
                    Nuovo Articolo
                </x-button-create>
            @endcan
        </x-slot:actions>
    </x-dashboard-index-header>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <x-filter-box
    title="Filtra gli articoli"
    description="Filtra gli articoli per autore o per area di ricerca"
>

    @can('edit all articles')
        <x-user-filter
            title="Autore"
            href="{{ route('admin.articles.index') }}"
            :users="$users"
        />
    @endcan

    <x-research-area-filter
        href="{{ route('admin.articles.index') }}"
        :researchAreas="$areas"
    />

    @if (
        request()->filled('userId') ||
        request()->filled('areaId')
    )
        <a
            href="{{ route('admin.articles.index') }}"
            class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
        >
            Rimuovi filtri
        </a>
    @endif

    @if (request()->filled('userId') || request()->filled('areaId'))

        <x-slot:activeFilters>

            @if (request()->filled('userId'))
                @php
                    $selectedUser = $users?->firstWhere('id', request('userId'));
                @endphp

                @if ($selectedUser)
                    <span class="rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
                        Autore:
                        {{ $selectedUser->name }}
                        {{ $selectedUser->surname }}
                    </span>
                @endif
            @endif

            @if (request()->filled('areaId'))
                @php
                    $selectedArea = $areas->firstWhere('id', request('areaId'));
                @endphp

                @if ($selectedArea)
                    <span class="rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
                        Area:
                        {{ $selectedArea->name }}
                    </span>
                @endif
            @endif

        </x-slot:activeFilters>

    @endif

</x-filter-box>

    <div class="space-y-3">
        @forelse ($articles as $article)

            <x-index-card
                :href="route('admin.articles.show', $article)"
                :title="$article->title"
            >

                <x-slot:image>
                    @if ($article->image_path)
                        <img
                            src="{{ Storage::url($article->image_path) }}"
                            alt="{{ $article->title }}"
                            class="absolute inset-0 h-full w-full object-cover"
                        >
                    @else
                        <div class="absolute inset-0 flex h-full w-full flex-col items-center justify-center bg-slate-800/50 text-center">
                            <div class="text-4xl leading-none text-slate-500">
                                <i class="fa-regular fa-file"></i>
                            </div>
                            <span class="mt-3 text-xs font-medium text-slate-400">
                                Nessuna immagine
                            </span>
                        </div>
                    @endif
                </x-slot:image>

                <x-slot:people>
                    <div class="mt-1 flex flex-wrap items-center gap-1 text-sm">

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
                </x-slot:people>

                <x-slot:details>
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
                </x-slot:details>

                <x-slot:description>
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($article->abstract),
                        180
                    ) }}
                </x-slot:description>

                <x-slot:actions>

                    @can('update', $article)

                        <x-modify-button-link
                            href="{{ route('admin.articles.edit', $article) }}"
                        >
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
                            action="{{ route('admin.articles.destroy', $article) }}"
                            id="delete_form_{{ $article->id }}"
                            class="hidden"
                        >
                            @csrf
                            @method('DELETE')
                        </form>

                    @endcan

                </x-slot:actions>

            </x-index-card>

        @empty

            <x-message-of-empty title="Nessun articolo trovato">
            </x-message-of-empty>

        @endforelse
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>

</x-layout-private>