<x-layout-menu-bar-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-event-box :events="$events" :event="$event"> 
        <x-slot:buttons>
            <x-button-create form="delete_form" href="/event" image="fa-solid fa-trash-can" class="bg-red-600 hover:bg-red-700 font-bold text-white">
                Cancella Evento
            </x-button-create>
            <x-link-button href="/events" class="my-2">Indietro</x-link-button>
        </x-slot:buttons>

        <x-event-content :event="$event"/>

        {{-- form per l'eliminazione dell'evento --}}
        <form action="/events/{{ $event->id }}" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
    </x-event-box>
</x-layout-menu-bar-private>