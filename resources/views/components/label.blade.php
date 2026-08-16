{{-- TODO: rimuovere poi tutta la logica di value (e pìil null di default per name, forse), 
ho aggiunto temporaneamente value solo per far funzionare tutti i componenti di default di jetstream
senza errori 
--}}
@props(['name' => null, 'value' => null, 'required' => false, 'description' => null])

<label {{ $attributes->class([
    'block font-medium text-white mb-1', // Classi fisse
    'after:content-["*"] after:text-red-500 after:ml-0.5' => $required // Classe condizionale
])->merge(['for' => $name]) }}>
    {{ $value ?? $slot }}
</label>

@if ($description)
    <p class="mb-3 mt-1 text-xs text-gray-400">
        {{ $description }}
    </p>
    
@endif