<x-layout-private>
    <x-slot:title>
        Crea Nuovo Utente
    </x-slot:title>

    <x-form-layout action="{{ route('admin.users-management.create') }}" method="POST" >
        <x-slot:header>
            <h1 class="text-base/7 font-semibold text-white">Aggiungi un nuovo collaboratore al gruppo di ricerca</h2>
            <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
        </x-slot:header>
        
        <x-content-box>
            
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text :required="true" name="name" label="Nome Utente" />
                <x-input-text :required="true" name="surname" label="Cognome Utente" />
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text type="email" :required="true" name="email" label="Email"/>
                <x-input-text type="password" :required="true" name="password" label="Password"/>
            </div>
        </x-content-box>

        <x-slot:buttons>
                <x-save-button type="submit" >Save</x-save-button>
                <a href="{{ route('admin.users-management.index') }}">
                    <x-danger-button type="button">Cancel</x-danger-button>
                </a>
        </x-slot:buttons>
    </x-form-layout>
</x-layout-private>