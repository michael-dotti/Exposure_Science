@props(['name', 'value' => ''])

<div class="quill-wrapper w-full mb-4">
    <input type="hidden" 
           name="{{ $name }}" 
           class="quill-hidden-input" 
           value="{{ old($name, $value) }}">
    
    <div class="quill-container bg-white text-black min-h-60 rounded-b-md">
        {!! old($name, $value) !!}
    </div>
</div>

{{-- Spinge lo script solo una volta, anche se usi il componente 5 volte nella pagina --}}
@pushOnce('scripts')
    @vite('resources/js/components/textarea-quill.js')
@endPushOnce