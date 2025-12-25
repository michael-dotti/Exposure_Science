@props(['active'])

@php
// Determiniamo il colore in base allo stato active
$colorClass = ($active ?? false) 
                ? 'text-cordes-accent'  // Colore Blu quando attivo
                : 'text-gray-400';     // Colore Grigio quando inattivo

// Uniamo il colore alle classi base (margine e hover)
$classes = $colorClass . ' mr-3 group-hover:text-white transition-colors';
@endphp

<i {{ $attributes->merge(['class' => $classes]) }}></i>

