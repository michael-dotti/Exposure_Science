@props([
    'title',
    'description',
    'resetUrl' => null,
    'activeFilters' => [] // Array vuoto di default
])

<!-- Corretto bg-white/3 in bg-white/[0.03] -->
<div class="mb-4 rounded-lg border border-white/10 bg-white/[0.03] px-4 py-3">

    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">

        <!-- Colonna di SINISTRA: Titolo e Descrizione -->
        <div>
            <h2 class="text-sm font-semibold text-white">
                {{ $title }}
            </h2>

            <p class="mt-1 text-xs text-gray-400">
                {{ $description }}
            </p>
        </div>

        <!-- Colonna di DESTRA: Raggruppa i filtri (sopra) e i badge (sotto) -->
        <div class="flex flex-col gap-2">

            <!-- Riga 1: Slot (Dropdowns) e Tasto Rimuovi -->
            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center">
                {{ $slot }}

                {{-- Il tasto "Rimuovi filtri" compare automaticamente se c'è almeno un filtro e un URL --}}
                @if (count($activeFilters) > 0 && $resetUrl)
                    <a
                        href="{{ $resetUrl }}"
                        class="inline-flex items-center justify-center rounded-md border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
                    >
                        Rimuovi filtri
                    </a>
                @endif
            </div>

            <!-- Riga 2: Badge dei filtri applicati -->
            @if (count($activeFilters) > 0)
                <div class="mt-2 flex flex-wrap items-center gap-2 lg:mt-0">
                    <span class="text-xs font-semibold text-gray-400">
                        Filtri applicati:
                    </span>

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