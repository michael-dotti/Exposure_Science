
@props(['name']) {{-- props che 
rappresenta il nome dell'errore che
viene inserito dall'esterno --}}

{{-- Quando c'è un 
errore nell'input prendi 
l'errore e msotralo a schermo usando
la variabile $message che contiene ilmessaggio di errore--}}
@error($name)
    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
@enderror

