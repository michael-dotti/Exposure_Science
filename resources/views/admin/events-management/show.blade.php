<x-layout-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-event-box :events="$events" :event="$event"> 
        <x-slot:buttons>
            <x-button-delete data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                Cancella Evento
            </x-button-delete>
            <x-link-button href="{{ route('admin.events-management.index') }}" class="my-2">Indietro</x-link-button>
        </x-slot:buttons>

        <x-event-content :event="$event" :showRecipients="true" />

        {{-- form per l'eliminazione dell'evento --}}
        <form action="{{ route('admin.events-management.destroy', $event->id) }}" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
    </x-event-box>

    <x-confirm-delete-modal form="delete_form">
        Sei sicuro di voler eliminare questo evento?
        <br>
        Verra rimosso definitivamente anche per tutti i destinatari.
    </x-confirm-delete-modal>
    <x-user-list-modal :users="$event->recipients" modalTitle="Destinatari" id="recipientsModal"/>
</x-layout-private>