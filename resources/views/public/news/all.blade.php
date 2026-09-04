<x-layout-public>
    <x-slot:title>
        Storico Notizie
    </x-slot:title>
    <x-slot:heading>
        Storico Notizie
    </x-slot:heading>

    <div class="w-full max-w-7xl mx-auto px-4 mt-6 text-white">
        {{-- BLOCCO AZIONI SUPERIORE (Bottone + Filtro) --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            {{-- Pulsante Indietro (Sinistra) --}}
            <div>
                <x-public-botton-back title="Torna alle ultime notizie" :href="route('public.news.index')" />
            </div>
            
            {{-- Filtro (Destra)--}}
            <div class="w-full sm:w-auto flex sm:justify-end">
                <x-news-sort-filter />
            </div>
            
        </div>
        @if($news)
            <h3 class="py-4 font-bold text-2xl font-sans text-amber-300 mb-4 mt-2">Tutte le notizie:</h3>
            <x-public-news-grid class="ml-10">
                @foreach ($news as $n)
                    <x-news-block :n='$n' hrefShow="{{ route('public.news.show',$n->id) }}" :showDate="true" />
                @endforeach
            </x-public-news-grid>
        @else
            <x-message-of-empty title="Nessuna Notizia al Momento" image="fa-regular fa-newspaper" />
        @endif
        </div>
    </div>

    <div class="mt-2">
        {{ $news->links() }}
    </div>

</x-layout-public>