@props(['name',
    'value'=> '',
    'label' => null, 
    'required' => false,
    'accept'=>'PDF, DOC, DOCX',
    'currentFile' => null
])
<div class="file-upload-group">
    {{-- label (non obbligatoria) --}}
    @if($label)
            <x-label :name="$name" :required="$required">
                {{ $label }}
            </x-label>
    @endif

    {{-- Mostra il file attuale se esiste ( per pagine edit) --}}
    @if($currentFile)
        <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
            <span>File attuale:</span>
            <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                {{ $currentFile }}
            </span>
        </div>
    @endif

    {{-- input file--}}
    <input {{ $attributes->merge([
            'type' => 'file',
            'name'=> $name,
            'aria-describedby'=>'file_input_help',
            'class' =>"check-file-size cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"]) }}
            id="{{ $name }}"
            @required($required)>
    {{-- Messaggio che specifica --}}
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ $accept }}</p>
    <x-error-message class="error-msg hidden">Il file è troppo grande (max 50MB)</x-error-message>
    <x-form-error :name="$name" />
</div>

@pushOnce('scripts')
    @vite('resources\js\components\file-max-size.js')  
@endPushOnce