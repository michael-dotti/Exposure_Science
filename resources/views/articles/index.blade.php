<x-layout-menu-bar-private>
    <x-slot:title>
        Articles 
    </x-slot:title>
    
    @can('create', App\Models\Article::class) 
        <x-button-create href="/articles/create">Nuovo Articolo</x-button-create>
    @endcan

    <div class="flex my-3 gap-3 items-center justify-center">
        @can('edit all articles')
            <x-user-filter href="/articles" :users="$users"></x-user-filter>
        @endcan
        <x-research-area-filter href="/articles" :researchAreas="$areas"></x-research-area-filter>
    </div>

    <div class="space-y-4 ml-6">
    @forelse ($articles as $article)
        <div class="flex px-4 py-6 border border-gray-200 rounded-lg shadow-sm">

            
            @if($article->image_path)
                <div class="shrink-0 w-48">
                    <img src="{{ asset('storage/' . $article->image_path) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-40 object-contain rounded-md border border-white/10">
                </div>
            @endif
            
            <div class="block pl-3">
                <div class="font-bold text-blue-500 text-sm mb-2"> 
                    Autori: <span class="text-white">{{ $article->users->pluck('name')->join(', ') }}</span>
                </div>
                <div class="font-bold text-blue-500 text-sm mb-2"> 
                    Argomento di ricerca: <span class="text-white">{{ $article->researchAreas->pluck('name')->join(', ') }}</span>
                </div>

                <div class="text-white" >
                    <a href="/articles/{{ $article->id }}" class="hover:underline">
                        <strong>{{ $article->title }}</strong>
                    </a>
                    :
                    <br>{!! $article->abstract !!}
                </div>
                @canany(['update', 'delete'], $article)
                    <div class="mt-4 flex gap-2">
                        @can('update', $article)
                        <x-modify-button-link href="/articles/{{ $article['id'] }}/edit">Modifica</x-modify-button-link>
                        @endcan
                        @can('delete', $article)
                            <x-danger-button form="delete_form_{{ $article->id }}" >Elimina</x-danger-button>
                            <form method="POST" action="/articles/{{ $article->id }}" id="delete_form_{{ $article->id }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            
                        @endcan

                    </div>
                @endcanany

            </div>
        </div>
    @empty
        <x-message-of-empty title="Nessun articolo trovato"></x-message-of-empty>
    @endforelse
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
    
</x-layout-menu-bar-private>