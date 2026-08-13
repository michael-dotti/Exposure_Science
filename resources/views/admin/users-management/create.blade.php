<x-layout-private>
    <x-slot:title>
        Crea Nuovo Utente
    </x-slot:title>

    <x-form-layout action="{{ route('admin.users-management.create') }}" method="POST" >
        <x-slot:header>
            <h1 class="text-base/7 font-semibold text-white">Aggiungi un nuovo collaboratore al gruppo di ricerca</h2>
            <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
        </x-slot:header>
        
        <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

        </div>

        <x-slot:buttons>
                <x-save-button type="submit" >Save</x-save-button>
                <a href="{{ route('admin.users-management.index') }}">
                    <x-danger-button type="button">Cancel</x-danger-button>
                </a>
        </x-slot:buttons>
    </x-form-layout>
</x-layout-private>