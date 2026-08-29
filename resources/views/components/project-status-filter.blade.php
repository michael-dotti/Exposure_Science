@props([
    'statuses', // Lista dei casi dell'Enum ProjectStatusType (ProjectStatusType::cases())
    'title' => 'Stato', // Titolo predefinito del menu a tendina
    'paramName' => 'status' // Nome della variabile nell'URL (default: status)
])

{{-- COMPONENTE CHE GENERA UN MENU A TENDINA PER LO STATO --}}
<x-dropdown class="inline-block">
    {{-- TITOLO DEL MENU A TENDINA --}}
    <x-slot name="trigger">
        <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20">
            Seleziona per {{ $title }} progetto

            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
            </svg>
        </button>
    </x-slot>

    {{-- CONTENUTO DEL MENU A TENDINA --}}
    <x-slot name="content">
        <div class="divide-y divide-gray-400">
            {{-- LINK CHE RIMUOVE IL FILTRO PER STATO --}}
            <x-dropdown-link
                href="{{ request()->fullUrlWithQuery([$paramName => null, 'page' => null]) }}"
            >
                Tutti
            </x-dropdown-link>
            
            <div class="py-1">
                {{-- FOREACH PER CICLARE I CASI DELL'ENUM --}}
                @foreach ($statuses ?? [] as $status)
                    {{-- 
                        $status->value  => assegna alla query URL il valore stringa ('planned', 'active', etc.)
                        $status->label() => mostra a schermo il testo leggibile ('Pianificato', 'Attivo', etc.)
                    --}}
                    <x-dropdown-link
                        href="{{ request()->fullUrlWithQuery([$paramName => $status->value, 'page' => null]) }}"
                    >
                        {{ $status->label() }}
                    </x-dropdown-link>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-dropdown>