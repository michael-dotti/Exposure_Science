<x-layout-menu-bar-private>
    <x-slot:title>
        Gestione Eventi
    </x-slot:title>
    <x-link-button href="/events-management/create" >Nuovo Evento</x-link-button>
    
    <div class="space-y-4">
    @forelse ($events as $event)
        <div class="flex px-4 py-6 border border-gray-200 rounded-lg shadow-sm">

            
            <div class="block pl-3">
                <div class="text-white" >
                    <a href="/events/{{ $event->id }}" class="hover:underline">
                        <strong>{{ $event->title }}</strong>
                    </a>
                    <p>da:</p>
                    <p>a:</p>
                    <br>{{ $event->content }}
                </div>

                <div class="mt-4 flex gap-2">
                    <x-modify-button-link href="/events-management/{{ $event->id }}/edit">Modifica</x-modify-button-link>
                    <x-danger-button form="delete_form_{{ $event->id }}" type="submit">Elimina</x-danger-button>
                    <form method="POST" action="/events-management/{{ $event->id }}" class="hidden" id="delete_form_{{ $event->id }}">
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
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun evento trovato</h3>
            
            <div class="mt-6">
                <a href="/events/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crea il primo evento del sito
                </a>
            </div>
        </div>
    @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</x-layout-menu-bar-private>