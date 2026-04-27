<x-layout-menu-bar>
    <x-slot:title>
    </x-slot:title>
    <x-slot:heading>
        {{ $article->title }}
    </x-slot:heading>
    <div>
        <div class="flex h-screen items-center justify-center bg-gray-900 p-5">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <p class="mb-6 font-bold text-white">{{ $article->abstract }}</p>
                <p class="mb-6 text-white">Leggi l'articolo intero: <a class="mb-6 font-bold text-white text-underline" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"> {{ $article->external_url }} </a></p>
            </div>
            <div class="mb-6 text-small text-white">
                <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72" />
            </div>
            </div>
        </div>
    </div>

    
</x-layout-menu-bar>