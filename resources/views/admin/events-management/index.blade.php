<x-layout-private>
    <x-slot:title>
        Gestione Eventi
    </x-slot:title>
    
     <x-event-index 
        :events="$events" 
        bulkDeleteRoute="admin.events-management.bulkDelete" 
        showRoute="admin.events-management.show" 
        > {{-- paso il nome della rotta come stringa e utilizzo {{ route(...) }} dentro al componente stesso--}}

        <x-slot:buttons>
            <x-button-create href="{{ route('admin.events-management.create') }}">Nuovo Evento</x-button-create>
            <x-event-type-filter href="{{ route('admin.events-management.index') }}" :types="$types"></x-event-type-filter>
            <x-danger-button data-modal-target="deleteModal" data-modal-toggle="deleteModal">Elimina Eventi selezionati</x-danger-button>
        </x-slot:buttons>
    </x-event-index>
    <x-confirm-delete-modal form="bulk-delete-form">
        Sei sicuro di voler eliminare questo/i evento/i?
        <br>
        Verrano eliminati anche ai destinatari dell'evento
    </x-confirm-delete-modal>
    
</x-layout-private>