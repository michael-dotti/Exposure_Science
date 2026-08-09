<x-layout-private>
    <x-slot:title>
        Articoli
    </x-slot:title>
    
    @can('create', App\Models\Article::class) 
        <x-button-create href="{{ route('admin.articles.create') }}">Nuovo Articolo</x-button-create>
    @endcan

    <div class="flex my-3 gap-3 items-center justify-center">
        @can('edit all articles')
            <x-user-filter href="/admin/articles" :users="$users"></x-user-filter>
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

                <div class="text-white" >
                    <a href="{{ route('admin.articles.show',$article->id) }}" class="hover:underline">
                        <strong>{{ $article->title }}</strong>
                    </a>
                    :
                    <br>{!! $article->abstract !!}
                </div>
                @canany(['update', 'delete'], $article)
                    <div class="mt-4 flex gap-2">
                        @can('update', $article)
                            <x-modify-button-link href="{{ route('admin.articles.edit',$article->id) }}">Modifica</x-modify-button-link>
                        @endcan
                        @can('delete', $article)
                            <x-danger-button form="delete_form_{{ $article->id }}" >Elimina</x-danger-button>
                            <form method="POST" action="{{ route('admin.articles.destroy',$article->id) }}" id="delete_form_{{ $article->id }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            
                        @endcan

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
    
</x-layout-private>