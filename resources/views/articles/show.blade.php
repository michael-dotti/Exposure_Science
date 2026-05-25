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
                        <x-nav-link class="mb-6 font-bold text-white text-underline" href="{{ $article->external_url }}"> 
                            {{ $article->external_url }}
                        </x-nav-link>
                    </p>
                @endif

            </div>
            <div class="mb-6 text-small text-white">
                <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72" />
            </div>
            </div>
        </div>
    </div>

    
    

    <footer class="absolute bottom-0 flex justify-between items-center pb-4 pr-4">
        <div class="flex items-center gap-3">
            <a href="/articles/{{ $article['id'] }}/edit" class="text-xs bg-yellow-400 text-black px-2 py-1 rounded">Modifica</a>
            
            <form action="/articles/{{ $article['id'] }}" method="POST" class="m-0 p-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:cursor-pointer">Elimina</button>
            </form>
        </div>

        <div>
            <x-link-button href="/articles">back</x-link-button>
        </div>
    </footer>
    
</x-layout-menu-bar-private>