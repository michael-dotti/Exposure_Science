<x-layout-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-event-box :events="$events" :event="$event"> 
        <x-slot:buttons>
            <x-button-delete form="delete_form_me">
                Cancella Evento Per Me
            </x-button-delete>
            <x-button-delete form="delete_form_all">
                Cancella Evento Per Tutti
            </x-button-delete>
            <x-link-button href="/admin/events-management" class="my-2">Indietro</x-link-button>
        </x-slot:buttons>

        <x-event-content :event="$event"/>

        {{-- form per l'eliminazione dell'evento --}}
        <form action="/admin/events-management/{{ $event->id }}/me" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
        <form action="/admin/events-management/{{ $event->id }}/all" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
    </x-event-box>
</x-layout-private>