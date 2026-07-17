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
        <div class="items-center justify-center bg-gray-900">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
                <div class="shadow-xl/20 shadow-gray-800">
                    <h1 class="mb-1 font-bold text-white">Astratto</h1>
                    <p class="mb-4 ml-6 font-medium text-white">{{ $article->abstract }}</p>
                </div>

                <div>
                    <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72 bg-gray-800 p-3" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="rounded-md bg-gray-800
                p-2">
                    <h2 class="bg-gray-900
                    rounded-md p-3
                    text-xl font-bold text-white">
                        OTTIENI L'ARTICOLO
                    </h2>
                    <hr class="w-48 my-3 h-1 mx-auto bg-neutral-quaternary border-0 rounded-sm">
                    <h3 class="text-l text-white mx-2">
                        @if($article->file_path)
                            <p class="mb-6 text-white">
                                <a class="text-cyan-400
                                transition duration-200
                                hover:text-cyan-600" href="/articles/{{ $article->id }}/download">
                                    Scarica l'articolo intero
                                </a>
                            </p>
                        @else
                            <p class="mb-6 text-white">
                                Leggi l'articolo intero a:
                                <a class="text-cyan-400
                                transition duration-200
                                hover:text-cyan-600" href="{{ $article->external_url }}"> 
                                    {{ $article->external_url }}
                                </a>
                            </p>
                        @endif
                    </h3>
            </div>
        </div>
    </div>

    
</x-layout-menu-bar-public>