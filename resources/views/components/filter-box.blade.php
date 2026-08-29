@props([
    'title', // titolo che appare a schermo (obbligatorio)
    'description', // descrizione che appare a schermo (obbligatorio)
    'resetUrl' => null, // l'url per azzerare la ricerca, se non viene passato di default vale null
    'activeFilters' => [] // L'array contenente i filtri applicati. Di default è un array vuoto [], così da evitare errori PHP se non viene passato alcun filtro.
])


<div class="mb-4 rounded-lg border border-white/10 bg-white/3 px-4 py-3">

    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">

        {{--INTESTAZIONE: titolo e descrizione --}}
        <div>
            <h2 class="text-sm font-semibold text-white">
                {{ $title }}
            </h2>

            <p class="mt-1 text-xs text-gray-400">
                {{ $description }}
            </p>
        </div>

        {{-- Colonna di DESTRA: Raggruppa i filtri (sopra) e i badge (sotto) --}}
        <div class="flex flex-col gap-2">

            <!-- Riga 1: Slot (Dropdowns) e Tasto Rimuovi -->
            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center">
                {{ $slot }}

                {{-- Il tasto "Rimuovi filtri" compare automaticamente se c'è almeno un filtro attivo ed è stato passato $resetURL --}}
                @if (count($activeFilters) > 0 && $resetUrl)
                    <a
                        href="{{ $resetUrl }}"
                        class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
                    >
                        Rimuovi filtri
                    </a>
                @endif
            </div>

            
            {{-- MOSTRA GRAFICAMENTE I FILTRI ATTIVATI --}}
            @if (count($activeFilters) > 0) {{-- mostra la sezione sol ose ci sono filtri attivi --}}
                <div class="mt-2 flex flex-wrap items-center gap-2 lg:mt-0">
                    <span class="text-xs font-semibold text-gray-400">
                        Filtri applicati:
                    </span>
                    
                    {{-- Ciclo @foreach che scorre l'array $activeFilters passato dal controller --}}
                    @foreach ($activeFilters as $filter)
                        <span class="rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">
                            {{ $filter['label'] }}: {{ $filter['value'] }}
                        </span>
                    @endforeach
                </div>
            @endif

        </div>

    </div>
</div>