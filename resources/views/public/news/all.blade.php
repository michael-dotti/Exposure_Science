<x-layout-public>
    <x-slot:title>
        Storico Notizie
    </x-slot:title>
    <x-slot:heading>
        Storico Notizie
    </x-slot:heading>

    <div class="text-white max-w-6xl mx-auto">
        @if($news)
            <h3 class="px-1 py-4 font-bold text-2xl font-sans text-amber-300 my-4">Tutte le notizie:</h3>
            <div class="flex justify-center items-center">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($news as $n)
                        <x-news-block :n='$n' hrefShow="{{ route('public.news.show',$n->id) }}" :showDate="true" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="mt-2">
        {{ $news->links() }}
    </div>

</x-layout-public>