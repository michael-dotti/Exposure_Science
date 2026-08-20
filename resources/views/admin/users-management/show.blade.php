<x-layout-private>
    <x-slot:title>
        Users Show
    </x-slot:title>
    
    <x-user-show :user="$user" :isUserManagement="true" />
    <hr class="h-1 mb-8 mt-12 bg-gray-100 border-0 rounded-sm">
    <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
        @foreach ($roles as $role)
            <x-role-checkbox 
                :role="$role" 
                :isEdit="true"
                :user="$user" 
            />
        @endforeach
    </div>
</x-layout-private>