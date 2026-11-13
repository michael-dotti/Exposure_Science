<x-layout-private>
    <x-slot:title>
        Evento
    </x-slot:title>
    <x-event-box 
        :event="$event" 
        :prevEventId="$prevEventId" 
        :nextEventId="$nextEventId" 
        :totalEvents="$totalEvents" 
        :currentPage="$currentPage" 
        baseRoute="admin.events.show"> 
        <x-slot:buttons>
            <x-button-delete form="delete_form">
                Cancella Evento
            </x-button-delete>
            <x-private-button-back :href="route('admin.events.index')" class="my-2" />
        </x-slot:buttons>

        <x-event-content :event="$event"/>

        {{-- form per l'eliminazione dell'evento --}}
        <form action="{{ route('admin.events.destroy',$event->id) }}" method="post" class="hidden" id="delete_form">
            @csrf
            @method('DELETE')
        </form>
    </x-event-box>
</x-layout-private>