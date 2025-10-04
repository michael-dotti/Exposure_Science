@props(['active'])

@php
// un operatore ternario ->  condizione ? cosa fare se è vero : cosa fare se + falso
$classes = ( ($active ?? false) // verifica se il props 'active' è diverso da null altrimenti da come valore false
            ? 'bg-gray-900 '
            : 'text-gray-300 hover:bg-gray-700 hover:text-white'
        ). 'rounded-md  px-3 py-2 text-base font-medium block text-white';
/* a seconda del valore di active assegno un certo valore alla variabile $classes,
 che poi uso sotto per assegnare il valore all'attributo class */
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}> 
    {{ $slot }}
</a>
