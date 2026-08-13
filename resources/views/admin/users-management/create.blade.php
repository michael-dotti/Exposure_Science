<x-layout-private>
    <x-slot:title>
        Crea Nuovo Utente
    </x-slot:title>

    <x-form-layout action="{{ route('admin.users-management.store') }}" method="POST" >
        <x-slot:header>
            <h1 class="text-base/7 font-semibold text-white">Aggiungi un nuovo collaboratore al gruppo di ricerca</h2>
            <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
        </x-slot:header>
        
        <x-content-box>
            <x-label class="md:text-lg mb-6">Inserisci i dati base del nuovo utente</x-label>
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text :required="true" name="name" label="Nome Utente" />
                <x-input-text :required="true" name="surname" label="Cognome Utente" />
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text type="email" :required="true" name="email" label="Email"/>
                <x-input-text type="password" :required="true" name="password" label="Password"/>
            </div>
        </x-content-box>

        <x-content-box>
            <x-label class="md:text-lg mb-6">Assegna un ruolo al nuovo utente</x-label>
            <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                @foreach ($roles as $role)
                    <x-role-checkbox :role="$role" />
                @endforeach
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