<x-layout-public>

    <x-slot:title>
        {{ $n->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-5xl px-4 py-8 text-center sm:px-6 lg:px-8">
            <h1 class="wrap-break-word text-5xl font-bold leading-tight text-amber-300">
                {{ $n->title }}
            </h1>
        </div>
    </x-slot:heading>

    <x-news-show 
        :news="$n"
    >
        <x-slot:buttonBack>
             <x-public-button-back
                title="Torna alle novità"
                :href="route('public.news.index')"
            />
        </x-slot:buttonBack>
    </x-news-show>
    
</x-layout-public>