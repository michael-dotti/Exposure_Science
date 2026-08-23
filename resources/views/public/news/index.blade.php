<x-layout-public>
    <x-slot:title>
        Novità
    </x-slot:title>
    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Le ultime notizie
            </h1>

            <p class="max-w-2xl mx-auto mt-3 text-base text-gray-300">
                Scopri cosa c'è di nuovo.
            </p>
        </div>
    </x-slot:heading>

    <div class="text-white mt-10">
        @if($news->isNotEmpty())          
            <div class="relative max-w-6xl mx-auto h-100 md:h-137.5 rounded-xl overflow-hidden mb-12 shadow-lg transition hover:-translate-y-1">
                <a href="{{ route('public.news.show',$news[0]->id) }}" class="font-bold text-sm hover:text-blue-400 transition"> 
                <img src="{{ Storage::url($news[0]->image_path)}}"
                alt="{{ $news[0]->title }}"
                class="absolute inset-0 w-full h-full object-cover object-center -z-20">
                    <div class="absolute inset-0 bg-black opacity-50 -z-10"></div>
                    
                    <!-- Il contenuto (Titolo) -->
                    <div class="relative z-10 p-10 h-full flex items-end">
                        <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">
                            {{ $news[0]->title }}
                        </h1>
                    </div>
            </a>
            </div>

            <div class="flex justify-center items-center">
                <div class="grid grid-cols-2 gap-4">
                    @for ($i = 1; $i < count($news); $i++)
                        <x-news-block :n="$news[$i]" hrefShow="{{ route('public.news.show',$n->id) }}"/>
                    @endfor
                </div>
            </div>
        
            <div class="my-4">
                <a href="{{ route('public.news.all') }}">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Vedi Storico Notizie
                    </button>
                </a>
            </div>
        @else
            <x-message-of-empty title="Nessuna News al Momento" image="fa-regular fa-newspaper" />
        @endif
    </div>

</x-layout-public>