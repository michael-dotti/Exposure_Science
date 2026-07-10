@props(['href'=>'/','image'=>'fa-solid fa-plus'])

<a href="{{ $href }}" {{ $attributes->merge(['class'=>'self-start inline-flex items-center px-4 py-2 my-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-200']) }}>
    <i class="{{ $image }} -ml-1 mr-2"></i>
    {{ $slot }}
</a>
{{-- Nota bene: componente pensato solo per nella parte iniziale della pagina index, 
se usato in altri punti della pagina la classe "self-start" può causare problemi --}}