<x-layout-private>
    <x-slot:title>
        Users Show
    </x-slot:title>
    
    
    @foreach ($roles as $role)
        <x-role-checkbox 
            :role="$role" 
            :isEdit="true"
        />
    @endforeach
</x-layout-private>