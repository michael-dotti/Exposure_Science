<x-layout-private>

    <x-slot:title>
        {{ $news->title }}
    </x-slot:title>

    <x-news-show 
        :news="$news"
    >
        <x-slot:buttonBack>
             <x-private-button-back
                title="Torna alle novità"
                :href="route('admin.news-management.index')"
            />
        </x-slot:buttonBack>

        
    </x-news-show>
    
</x-layout-private>