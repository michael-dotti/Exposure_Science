<x-layout-private>

    <x-slot:title>
        {{ $news->title }}
    </x-slot:title>

    <x-news-show 
        :news="$news"
    >
        <x-slot:button_back>
             <x-private-button-back
                title="Torna alle novità"
                :href="route('admin.news-management.index')"
            />
        </x-slot:button_back>
    </x-news-show>
    
</x-layout-private>