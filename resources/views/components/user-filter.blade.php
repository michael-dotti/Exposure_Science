{{-- PROPS PER PASSARE I DATI DI CUI A BISOGNO IL MENU A TENDINA --}}
@props([
    'users', // LISTA DEGLI UTENTI PRESENTI NEL SITO
    'href', // URL (meglio se generato con i nomi delle rotte) DELLA PAGINA INDEX IN CUI CI TROVIAMO 
    'title'=>'Autore' // TITOLO DEL MENU A TENDINA
])

{{-- COMPONENTE CHE GENERA UN MENU A TENDINA --}}
<x-dropdown class="inline-block">
{{-- TITOLO DEL MENU A TENDINA --}}
<x-slot name="trigger">
    <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20">
        Seleziona per {{ $title }}


        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </button>
</x-slot>

{{-- CONTENUTO DEL MENU A TENDINA --}}
<x-slot name="content">
    <div class="divide-y divide-gray-400">
        {{-- LINK CHE RIMUOVE IL FILTRO PER UTENTI --}}
        <x-dropdown-link
            href="{{ request()->fullUrlWithQuery(['userId' => null, 'page' => null]) }}"
        > Tutti </x-dropdown-link>
        
        <div class="py-1">
            {{-- FOREACH PER CICLARE I VARI UTENTI --}}
            {{-- USIAMO ?? [] PER SICUREZZA SE $users DOVESSE ESSERE NULL --}}
            @foreach ($users ?? [] as $user)
                {{-- LINK PER FILTRARE (imposta userId e resetta la pagina) --}}
                <x-dropdown-link
                    href="{{ request()->fullUrlWithQuery(['userId' => $user->id, 'page' => null]) }}"
                >
                    {{ $user->name }} {{ $user->surname }}
                </x-dropdown-link>
            @endforeach
        </div>
    </div>
</x-slot>
</x-dropdown>