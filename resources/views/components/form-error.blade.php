
@props(['name']) {{-- props che 
rappresenta il nome dell'errore che
viene inserito dall'esterno --}}

@php
    // Rimuove eventuali wildcard esistenti per ricavare il campo base
    $cleanName = str_replace('.*', '', $name);
@endphp


{{-- 1. Controlla se c'è un errore riguardo al campo "name" e stamapa schermo i suoi messaggi d'errore --}}
@error($cleanName)
    <x-error-message>{{ $message }}</x-error-message>
@enderror

{{-- 2. se il campo "name", dobbiamo verificare se ci sono errori sui singol ielementi dell'array usando .* --}}
@error("$cleanName.*")
    <x-error-message>{{ $message }}</x-error-message>
@enderror



