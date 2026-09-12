<x-layout-private>
    <x-slot:title>
        Articoli
    </x-slot:title>

    <x-dashboard-index-header
        title="Gestione Articoli"
        subtitle="Visualizza e gestisci gli articoli presenti nel portale"
    >
        <x-slot:actions>
            <x-button-create href="{{ route('admin.articles.create') }}">
                Nuovo Articolo
            </x-button-create>
        </x-slot:actions>

        <x-slot:filters>
            <x-filter-box
                title="Filtra gli articoli"
                description="Filtra gli articoli per autore o per area di ricerca"
                resetUrl="{{ route('admin.articles.index') }}"
                :activeFilters="$currentFilters"
            >
                @can('edit all articles')
                    <x-user-filter
                        :users="$users"
                    />
                @endcan

                <x-research-area-filter
                    :researchAreas="$areas"
                />

            </x-filter-box>
        </x-slot:filters>
    </x-dashboard-index-header>

   
    <div class="space-y-3">
        @forelse ($articles as $article)

            <x-index-card
                :href="route('admin.articles.show', $article)"
                :title="$article->title"
                :flushImage="true"
                imageWidth="sm:w-72"
            >

                <x-slot:image>
                   <img
                        src="{{ Storage::url($article->image_path) }}"
                        alt="{{ $article->title }}"
                        class="absolute inset-0 h-full w-full object-cover"
                    >
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
                    <x-modify-button-link
                        href="{{ route('admin.articles.edit', $article) }}"
                    >
                        Modifica
                    </x-modify-button-link>
                
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
                </x-slot:actions>
            </x-index-card>
        @empty
            <x-message-of-empty title="Nessun articolo trovato" />
        @endforelse
    </div>

    <div class="my-6">
        {{ $articles->links() }}
    </div>

</x-layout-private>