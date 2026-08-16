<x-layout-private>
    <x-slot:title>
        Users Show
    </x-slot:title>
    
    <x-user-show :user="$user" :isUserManagement="true" />
    @foreach ($roles as $role)
        <x-role-checkbox 
            :role="$role" 
            :isEdit="true"
            :user="$user" 
        />
    @endforeach
</x-layout-private>