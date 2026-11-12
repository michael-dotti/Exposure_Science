<x-layout-private>
    <x-slot:title>
        Crea Nuovo Utente
    </x-slot:title>

    <x-form-layout action="{{ route('admin.users-management.store') }}" method="POST" >
        <x-slot:header>
            <h1 class="text-base/7 font-semibold text-white">Aggiungi un nuovo collaboratore al gruppo di ricerca</h2>
        </x-slot:header>
        
        <x-content-section>
            <x-label class="md:text-lg mb-6">Inserisci i dati base del nuovo utente</x-label>
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text :required="true" name="name" label="Nome Utente" />
                <x-input-text :required="true" name="surname" label="Cognome Utente" />
            </div>
            <x-input-text type="email" :required="true" name="email" label="Email"/>
            <div class="grid md:grid-cols-2 md:gap-6">
                <x-input-text type="password" :required="true" :use-old="false" name="password" label="Password"/>
                <x-input-text type="password" :required="true" :use-old="false" name="password_confirmation" label="Conferma Password"/>
            </div>
        </x-content-section>

        <x-content-section>
            <x-label class="md:text-lg mb-6" >Assegna un ruolo al nuovo utente</x-label>
            
            <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                @foreach ($roles as $role)
                    <x-role-checkbox :role="$role" />
                @endforeach
            </div>
            
            <x-form-error name="roles" />
        </x-content-section>

        <x-slot:buttons>
            <x-save-button type="submit" >Save</x-save-button>
            <a href="{{ route('admin.users-management.index') }}">
                <x-danger-button type="button">Cancel</x-danger-button>
            </a>
        </x-slot:buttons>
    </x-form-layout>
</x-layout-private>