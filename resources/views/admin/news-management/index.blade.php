<x-layout-private>
    <x-slot:title>
        Gestione Notizie
    </x-slot:title>
    <x-button-create href="{{ route('admin.news-management.create') }}">Nuova Notizia</x-button-create>

   <div class="space-y-3">
        @forelse ($news as $n)
            <x-index-card
                :href="route('admin.news-management.show', $n)"
                :title="$n->title" 
            >
                <x-slot:image>
                    <div class="flex h-36 w-full items-center justify-center overflow-hidden rounded-lg border border-blue-400/20 bg-blue-500/5">
                        <img src="{{ Storage::url($n->image_path) }}"
                                alt="{{ $n->title }}" 
                                class="w-full h-40 object-contain rounded-md border border-white/10">
                    </div>
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