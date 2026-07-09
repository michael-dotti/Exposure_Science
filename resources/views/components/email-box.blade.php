@props(['events','event'])

<div class="w-full flex-1 bg-white shadow-xl rounded-lg flex flex-col overflow-hidden border border-mist-600">
    
    <div class="min-h-16 py-3 px-4 flex flex-wrap items-center justify-between border-b gap-4 border-gray-200 bg-mist-700 shrink-0">
        
        <div class="flex flex-wrap gap-2">
            <x-button-create form="delete_form" href="/event" image="fa-solid fa-trash-can" class="bg-red-600 hover:bg-red-700 font-bold text-white">
                Cancella Evento
            </x-button-create>
            <x-link-button href="/events" class="my-2">Indietro</x-link-button>
        </div>
        
        @if( $events->hasPages())
            {{ $events->links('partials.event-show-pagination') }}
        @endif
    </div>

    <div class="flex-1 bg-mist-700 p-6 overflow-y-auto custom-scrollbar">
        {{ $slot }}
    </div>
</div>
<form action="/events/{{ $event->id }}" method="post" class="hidden" id="delete_form">
    @csrf
    @method('DELETE')
</form>