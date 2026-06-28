@props(['name',
    'value'=> '',
    'label' => null, 
    'required' => false,
    'accept'=>'PDF, DOC, DOCX'
])

{{-- label (non obbligatoria) --}}
@if($label)
        <x-label :name="$name" :required="$required">
            {{ $label }}
        </x-label>
@endif
{{-- input file--}}
<input {{ $attributes->merge([
        'type' => 'file',
        'name'=> $name,
        'id' => $name,
        'aria-describedby'=>'file_input_help',
        'class' =>"cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"]) }}
        value="{{ old($name, $value) }}"
        @required($required)>
{{-- Messaggio che specifica --}}
<p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOC, DOCX</p>

<x-form-error :name="$name" />