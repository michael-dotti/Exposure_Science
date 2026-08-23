<x-layout-private>
    <x-slot:title>
        Gestione News
    </x-slot:title>
    <x-button-create href="{{ route('admin.news-management.create') }}">Nuova Notizia</x-button-create>

    <div class="space-y-4 mt-4">
        @if($news->isEmpty())
            <x-message-of-empty title="Nessuna notizia trovata" description="Crea la prima notizia del sito">
                <x-button-create href="{{ route('admin.news-management.create') }}" text="Nuova News" class="mt-2"></x-button-create>
            </x-message-of-empty>
        @else
            @foreach ($news as $n)
                <div class="flex px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                    
                    @if($n->image_path) {{-- if non necessario, image_path è obbligatorio --}}
                        <div class="shrink-0 w-48">
                            <img src="{{ asset('storage/' . $n->image_path) }}"
                                alt="{{ $n->title }}" 
                                class="w-full h-40 object-contain rounded-md border border-white/10">
                        </div>
                    @endif
                    
                    <div class="block pl-3">
                        <div class="text-white" >
                            <a href="{{ route('admin.news-management.show',$n->id) }}" class="hover:underline">
                                <strong>{{ $n->title }}</strong>
                            </a>
                            : 
                            <p class="text-sm mt-1"> {{ Str::limit(strip_tags($n->content), 240, '...') }} </p>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <x-modify-button-link href="{{ route('admin.news-management.edit',$n->id) }}">Modifica</x-modify-button-link>
                            <x-danger-button form="delete_form_{{ $n->id }}" type="submit">Elimina</x-danger-button>
                            <form method="POST" action="{{ route('admin.news-management.destroy',$n->id) }}" class="hidden" id="delete_form_{{ $n->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>

                    </div>
                </div>
                @endforeach
        @endif
    </div>
</x-layout-private>