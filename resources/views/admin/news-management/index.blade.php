<x-layout-private>
    <x-slot:title>
        Notizie del Gruppo di Ricerca
    </x-slot:title>
    
    <x-dashboard-index-header
        title="Gestione Notizie"
        subtitle="Visualizza e gestisci le notizie sul gruppo di ricerca"
    >
        <x-slot:actions>
            <x-button-create href="{{ route('admin.news-management.create') }}">Nuova Notizia</x-button-create>
        </x-slot:actions>
    </x-dashboard-index-header>
   <div class="space-y-3">
        @forelse ($news as $n)
            <x-index-card
                :href="route('admin.news-management.show', $n)"
                :title="$n->title"
                imageWidth="sm:w-72" 
                :flushImage="true" 
            >
                <x-slot:image>
                    <img src="{{ Storage::url($n->image_path) }}"
                         alt="{{ $n->title }}" 
                         class="absolute inset-0 h-full w-full object-cover">
                </x-slot:image>

                <x-slot:description>
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($n->content),
                        180
                    ) }}
                </x-slot:description>
                <x-slot:actions>
                    <x-modify-button-link href="{{ route('admin.news-management.edit',$n->id) }}">
                        Modifica
                    </x-modify-button-link>
                    <x-danger-button form="delete_form_{{ $n->id }}" type="submit">
                        Elimina
                    </x-danger-button>
                    <form 
                        method="POST" 
                        action="{{ route('admin.news-management.destroy',$n->id) }}" 
                        class="hidden" 
                        id="delete_form_{{ $n->id }}"
                    >
                        @csrf
                        @method('DELETE')
                    </form>
                </x-slot:actions>  

            </x-index-card>
        @empty
            <x-message-of-empty title="Nessuna Notizia Trovata" image="fas fa-newspaper" />
        @endforelse
        
    </div>
</x-layout-private>