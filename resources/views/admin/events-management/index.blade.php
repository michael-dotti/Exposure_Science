<x-layout-private>
    <x-slot:title>
        Gestione Eventi
    </x-slot:title>
    
     <x-event-index 
        :events="$events" 
        bulkDeleteRoute="admin.events-management.bulkDelete" 
        showRoute="admin.events-management.show" 
        >

        <x-slot:buttons>
            <x-button-create href="{{ route('admin.events-management.create') }}">Nuovo Evento</x-button-create>
            <x-event-type-filter href="{{ route('admin.events-management.index') }}" :types="$types"></x-event-type-filter>
            <x-danger-button form="bulk-delete-form">Elimina Eventi selezionati</x-danger-button>
        </x-slot:buttons>
    </x-event-index>
    {{-- paso il nome della rotta come stringa e utilizzi {{ route(...) }} dentro al componente stesso--}}
</x-layout-private>