<x-layout-menu-bar-public>
    <x-slot:title>
    </x-slot:title>
    <x-slot:heading>
        <div class="text-white text-3xl"> {{ $article->title }} </div>
        <pre class="text-white text-sm">{{ $article->researchAreas->pluck('name')->join(', ') }}</pre>
        <pre class="text-white text-sm">di @foreach($article->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach
        </pre>
    </x-slot:heading>
    <div>
        <div class="flex h-screen items-center justify-center bg-gray-900 p-5">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <p class="mb-6 font-bold text-white">{!! $article->abstract !!}</p>

                @if($article->file_path)
                    <p class="mb-6 text-white">
                        <x-nav-link class="mb-6 font-bold text-white text-underline" href="/articles/{{ $article->id }}/download">
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

    
</x-layout-menu-bar-public>