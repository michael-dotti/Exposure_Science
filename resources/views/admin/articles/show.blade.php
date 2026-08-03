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
            <div class=" text-white grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <p class="mb-6 font-bold">{!! $article->abstract !!}</p>

                @if($article->document)
                    <div class="mb-6">
                        <x-button-download :file="$article->document" text="Scarica l'articolo scientifico:"/>
                    </div>
                @else
                    <p class="mb-6 ">
                        Leggi l'articolo intero:
                        <x-nav-link class="truncate mb-6 font-bold  text-underline" href="{{ $article->external_url }}"> 
                            {{ $article->external_url }}
                        </x-nav-link>
                    </p>
                @endif

            </div>
            @if($article->image_path)
                <div class="mb-6 text-small ">
                    <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72" />
                </div>
            @endif
            </div>
        </div>
    </div>

    
    <form method="POST" action="{{ route('admin.articles.destroy',$article->id) }}" id="delete_form" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    <footer>
        @canany(['update', 'delete'], $article)
            <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3 right-1">
                @can('update', $article)
                    <x-modify-button-link href="{{ route('admin.articles.edit',$article->id) }}" >Modifica</x-modify-button-link>
                @endcan
                @can('delete', $article)
                    <x-danger-button form="delete_form">Elimina</x-danger-button>
                @endcan
            </div>
        @endcanany
        
        <div class="absolute bottom-0 justify-between pb-4 pr-4 flex items-center gap-3">
            <x-link-button href="{{ route('admin.articles.index') }}" >back</x-link-button>
        </div>  
    </footer>
    
</x-layout-private>