@props(['name', 'required' => false])

<label {{ $attributes->class([
    'block font-medium text-white mb-1', // Classi fisse
    'after:content-["*"] after:text-red-500 after:ml-0.5' => $required // Classe condizionale
])->merge(['for' => $name]) }}>
    {{ $slot }}
</label>