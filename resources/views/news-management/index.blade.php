<x-layout-menu-bar-private>
    <x-slot:title>
        Gestione News
    </x-slot:title>
    <x-bottom-create href="/news-management/create" text="Nuova Notizia"></x-bottom-create>
    
    <div class="space-y-4">
        @if($news->isEmpty())
            <x-message-of-empty title="Nessuna notizia trovata" description="Crea la prima notizia del sito">
                <x-bottom-create href="/news-management/create" text="Nuova News" class="mt-2"></x-bottom-create>
            </x-message-of-empty>
        @else
            @forelse ($news as $n)
                <div class="flex px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                    
                    @if($n->imagePath)
                        <div class="shrink-0 w-48">
                            <img src="{{ asset('storage/' . $n->imagePath) }}"
                                alt="{{ $n->title }}" 
                                class="w-full h-40 object-contain rounded-md border border-white/10">
                        </div>
                    @endif
                    
                    <div class="block pl-3">
                        <div class="text-white" >
                            <a href="/news/{{ $n->id }}" class="hover:underline">
                                <strong>{{ $n->title }}</strong>
                            </a>
                            :
                            <br>{{ $n->content }}
                        </div>

                        <div class="mt-4 flex gap-2">
                            <x-modify-button-link href="/news-management/{{ $n->id }}/edit">Modifica</x-modify-button-link>
                            <x-danger-button form="delete_form_{{ $n->id }}" type="submit">Elimina</x-danger-button>
                            <form method="POST" action="/news-management/{{ $n->id }}" class="hidden" id="delete_form_{{ $n->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            
                        </div>

                    </div>
                </div>
        @endif
    </div>
</x-layout-menu-bar-private>