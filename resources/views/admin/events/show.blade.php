<x-layout-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-event-box :events="$events" :event="$event"> 
        <x-slot:buttons>
            <x-button-delete form="delete_form">
                Cancella Evento
            </x-button-delete>
            <x-link-button href="{{ route('admin.events.index') }}" class="my-2">Indietro</x-link-button>
        </x-slot:buttons>

        <x-event-content :event="$event"/>

        {{-- form per l'eliminazione dell'evento --}}
        <form action="{{ route('admin.events.destroy',$event->id) }}" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
    </x-event-box>
</x-layout-private>