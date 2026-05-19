<x-layout-menu-bar-public>
    <x-slot:title>
        Novità
    </x-slot:title>
    <x-slot:heading>
        Novità
    </x-slot:heading>

    <div class="text-white">
        @if($news)
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach ($news as $n)
                            <div class="bg-[#253041]/80 border border-gray-500 rounded-lg p-3 flex-1 gap-2 transition hover:-translate-y-1">
                                <a href="/news/{{ $n->id }}" class="font-bold text-sm hover:text-blue-400 transition"> 
                                    {{ $n->title }} 
                                
                                
                                <div class="h-24 overflow-hidden rounded">
                                    <img src="{{ Storage::url($n->imagePath) }}" alt="news_image" class="w-full h-full object-cover">
                                </div>

                                <p class="text-xs text-gray-300">
                                    <span class="text-orange-400 font-semibold">{{ $n->publicationDate }}</span>
                                    {{ Str::limit($n->content, 60) }}
                                </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
    </div>

</x-layout-menu-bar-public>