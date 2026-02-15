<x-layout-menu-bar-user>
    <x-slot:title>
        Articles 
    </x-slot:title>
    
    <x-link-button href="/articles/create" >Nuovo articolo</x-link-button>
    
    <div class="space-y-4">
    @forelse ($articles as $article)
        <div class="flex px-4 py-6 border border-gray-200 rounded-lg shadow-sm">

            
            @if($article->image_path)
                <div class="flex-shrink-0 w-48">
                    <img src="{{ asset('storage/' . $article->image_path) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-40 object-contain rounded-md border border-white/10">
                </div>
            @endif
            
            <div class="block pl-3">
                <div class="font-bold text-blue-500 text-sm mb-2"> 
                    Autori: <span class="text-white">{{ $article->users->pluck('name')->join(', ') }}</span>
                </div>

                <div>
                    <a href="/articles/{{ $article['id'] }}" class="hover:underline">
                        <strong>{{ $article->title }}</strong>
                    </a>
                    :
                    <br>{{ $article->abstract }}
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="/articles/{{ $article['id'] }}/edit" class="text-xs bg-yellow-400 px-2 py-1 rounded">Modifica</a>
                    
                    <form action="/articles/{{ $article['id'] }}" method="POST" class="m-0 p-0 flex">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs bg-red-500 text-white px-2 py-1 rounded">Elimina</button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun articolo trovato</h3>
            <p class="mt-1 text-sm text-gray-500">Inizia pubblicando la tua prima ricerca scientifica.</p>
            
            <div class="mt-6">
                <a href="/articles/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crea il tuo primo articolo
                </a>
            </div>
        </div>
    @endforelse
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
    
    {{--  
    <div class="space-y-4">
        @foreach ( $articles as $article )
            <a href="/article/{{ $article['id'] }}" class=" block px-4 py-6 border border-gray-200 rounded-lg">
                <div class="font-bold text-blue-500 text-sm"> 
                {{ $article->user->name }} 
            </div>
                <div>
                    <strong>{{ $article['title'] }}</strong>:  {{ $article['abstract'] }} .
                </div>    
            </a>
        @endforeach
    </div>
    <div>
        {{  $articles->links()}} 
    </div>
    --}}
</x-layout-menu-bar-user>