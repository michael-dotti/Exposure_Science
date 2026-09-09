@props([
    'title' => '',
    'paramName' => 'sort'
])

{{-- COMPONENTE PER L'ORDINAMENTO DELLE NOTIZIE --}}
<x-dropdown class="inline-block">
    <x-slot name="trigger">
        <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20">
            Ordina {{ $title }}

            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
            </svg>
        </button>
    </x-slot>

    <x-slot name="content">
        <div class="divide-y divide-gray-400">
            {{-- OPZIONE: Più recenti (DESC - Default) --}}
            <x-dropdown-link
                href="{{ request()->fullUrlWithQuery([$paramName => null, 'page' => null]) }}"
            >
                Più recenti
            </x-dropdown-link>

            {{-- OPZIONE: Meno recenti (ASC) --}}
            <x-dropdown-link
                href="{{ request()->fullUrlWithQuery([$paramName => 'oldest', 'page' => null]) }}"
            >
                Meno recenti
            </x-dropdown-link>
        </div>
    </x-slot>
</x-dropdown>