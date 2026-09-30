<x-layout-private>
    <x-slot:title>
        {{ $user->name }} {{ $user->surname }}
    </x-slot:title>
    
    <x-user-private-show :user="$user" :roles="$roles" />
    
</x-layout-private>