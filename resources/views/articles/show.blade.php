<x-layout-menu-bar-private>
    <x-slot:title>
        Article
    </x-slot:title>

    

    <div class="flex">
        <div class="justify-start">
            <pre class="text-white text-3xl">{{ $article->title }}</pre>
            <pre class="text-white text-sm">{{ $article->researchAreas->pluck('name')->join(', ') }}</pre>
            <pre class="text-white text-sm">di @foreach($article->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach</pre>
        </div>
    </div>

    <div>
        <div class="flex">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <p class="mb-6 font-bold text-white">{{ $article->abstract }}</p>

                @if($article->file_path)
                    <p class="mb-6 text-white">
                        <x-nav-link class="mb-6 font-bold text-white text-underline" href="/download/{{ $article->file_path }}">
                            Scarica l'articolo intero
                        </x-nav-link>
                    </p>
                @else
                    <p class="mb-6 text-white">
                        Leggi l'articolo intero:
                        <x-nav-link class="truncate mb-6 font-bold text-white text-underline" href="{{ $article->external_url }}"> 
                            {{ $article->external_url }}
                        </x-nav-link>
                    </p>
                @endif

            </div>
            @if($article->image_path)
                <div class="mb-6 text-small text-white">
                    <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72" />
                </div>
            @endif
            </div>
        </div>
    </div>

    
    <form method="POST" action="/articles/{{ $article->id }}" id="delete_form" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    <footer>
        <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3">
            <a href="/articles/{{ $article['id'] }}/edit" class="text-xs bg-yellow-400 text-black px-2 py-1 rounded">Modifica</a>
            
            <x-button form="delete_form" class="bg-red-500 hover:bg-red-600">Elimina</x-button>
        </div>

        <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3 right-1">
            <button href="/articles" class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:cursor-pointer">
                <a href="/articles"> back </a>
            </button>
        </div>
    </footer>
    
</x-layout-menu-bar-private>