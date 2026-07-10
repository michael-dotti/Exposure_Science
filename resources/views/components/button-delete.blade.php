@props(['image'=>'fa-solid fa-trash-can'])

<button  {{ $attributes->merge(['class'=>'self-start inline-flex items-center px-4 py-2 my-2 border border-transparent shadow-sm text-sm rounded-md bg-red-600 hover:bg-red-700 font-bold text-white transition duration-200','type'=>'submit']) }}>
    <i class="{{ $image }} -ml-1 mr-2"></i>
    {{ $slot }}
</button>
