<x-layout-private>
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
                <p class="mb-6 font-bold text-white">{!! $article->abstract !!}</p>

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

    
    <form method="POST" action="/admin/articles/{{ $article->id }}" id="delete_form" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    <footer>
        @canany(['update', 'delete'], $article)
            <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3 right-1">
                @can('update', $article)
                    <x-modify-button-link href="/admin/articles/{{ $article['id'] }}/edit" >Modifica</x-modify-button-link>
                @endcan
                @can('delete', $article)
                    <x-danger-button form="delete_form">Elimina</x-danger-button>
                @endcan
            </div>
        @endcanany
        
        <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3">
            <x-link-button href="/admin/articles" >back</x-link-button>
        </div>  
    </footer>
    
</x-layout-private>