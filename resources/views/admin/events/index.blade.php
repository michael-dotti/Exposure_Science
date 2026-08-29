<x-layout-private>
    <x-slot:title>
        Events
    </x-slot:title>

    <x-event-index 
        :events="$events" 
        bulkDeleteRoute="admin.events.bulkDelete" 
        showRoute="admin.events.show" 
        >
        {{-- paso il nome della rotta come stringa e utilizzi {{ route(...) }} dentro al componente stesso--}}
        
        <x-slot:buttons>
            <x-event-type-filter :types="$types" />
            <x-danger-button disabled id="bulk-delete-btn" form="bulk-delete-form">Elimina Eventi selezionati</x-danger-button>
        </x-slot:buttons>
    </x-event-index>
   
    
</x-layout-private>