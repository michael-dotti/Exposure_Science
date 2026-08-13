<x-layout-private>
    <x-slot:title>
        Users Show
    </x-slot:title>
    
    <x-page-to-do />
    @foreach ($roles as $role)
        <x-role-checkbox 
            :role="$role" 
            :checked="old('_token') ? in_array($role->id, old('roles', [])) : $user->hasRole($role->name)" 
        />
    @endforeach
</x-layout-private>