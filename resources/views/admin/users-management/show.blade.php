<x-layout-private>
    <x-slot:title>
        Users Show
    </x-slot:title>
    
    <x-user-show :user="$user" :isUserManagement="true" />
    
    @if(Auth()->user()->id !== $user->id)
        <hr class="h-1 mb-8 mt-12 bg-gray-100 border-0 rounded-sm">
        <x-form-layout :button_back="false" method="PATCH" action="{{ route('admin.users-management.update', $user->id) }}" :divider="false" >
            <x-slot:header>
                <h2 class="text-xl font-bold text-amber-500">
                    Modifica i ruoli di {{ $user->name }} {{ $user->surname }}
                </h2>
            </x-slot:header>
            <x-content-section>
                <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                    @foreach ($roles as $role)
                        <x-role-checkbox 
                            :role="$role" 
                            :isEdit="true"
                            :user="$user" 
                        />
                    @endforeach
                </div>
            </x-content-section>
            <x-slot:buttons>
                <x-save-button type="submit">
                    Salva
                </x-save-button>
                <a href="{{ url()->previous() }}">
                    <x-danger-button type="button">
                        Annulla
                    </x-danger-button>
                </a>   
            </x-slot:buttons>
        </x-form-layout>
    @endif
</x-layout-private>