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

        <x-slot:actions>
            <x-modify-button-link href="{{ route('admin.news-management.edit', $news) }}">
                Modifica
            </x-modify-button-link>

            <x-danger-button 
                type="submit"
                form="delete_news"
            >
                Elimina
            </x-danger-button>

            <form
                method="POST"
                action="{{ route('admin.news-management.destroy', $news) }}"
                id="delete_news"
                class="hidden"
            >
                @csrf
                @method('DELETE')
            </form>
        </x-slot:actions>
    </x-news-show>
    
</x-layout-private>