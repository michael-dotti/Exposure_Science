@props([
    'href' => null,
    'withIcon' => false,
    'icon' => 'fa-solid fa-arrow-left'
])

@php
    // il valore di default del prop $href è url()->previous(), ma se inserissi questo valore in @props, otterei solo la stringa 'url()->previous()', non la funzione che calcola l'url precedente
    $href = $href ?? url()->previous();
@endphp

<x-link-button :href="$href" {{ $attributes }}>
    @if($withIcon)
        <i class="{{ $icon }} mr-2"></i> 
    @endif

    {{ $slot->isEmpty() ? 'Indietro' : $slot }}
</x-link-button>