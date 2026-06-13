<x-layout-menu-bar-private>
    <x-slot:title>
        Gestione News
    </x-slot:title>
    <x-link-button href="/news-management/create" >Nuova Notizia</x-link-button>
    
    <div class="space-y-4">
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
    @empty
        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nessuna notizia trovata</h3>
            
            <div class="mt-6">
                <a href="/news/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crea la prima news del sito
                </a>
            </div>
        </div>
    @endforelse
    </div>
</x-layout-menu-bar-private>