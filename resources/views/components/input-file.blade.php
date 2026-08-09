@props(['name', // attenzione: passa il nome con le [] se vuoi inserire più di un file
    'value'=> '',
    'label' => null, 
    'required' => false,
    'accept'=>'PDF, DOC, DOCX',
    'currentFile' => null,
    'multiple' => false // se è a true, il componente accetta n-file
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
            <span>{{ $multiple ? 'File attuali:' : 'File attuale:' }}</span>
            <div class="flex flex-wrap gap-2">
                @php
                    // Se currentFile è una stringa singola, lo trasformiamo in array per poterlo ciclare facilmente
                    $files = is_iterable($currentFile) ? $currentFile : [$currentFile];
                @endphp
                
                @foreach($files as $file)
                    <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                        {{ $file }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- input file--}}
    <input {{ $attributes->merge([
            'type' => 'file',
            'name'=> $name,
            'aria-describedby'=>'file_input_help',
            'class' =>"check-file-size cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
            ]) }}
            id="{{ str_replace('[]', '', $name) }}" 
            @if($multiple) multiple @endif
            @required($required)>
    {{-- Messaggio che specifica --}}
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ $accept }}</p>
    <x-error-message class="error-msg hidden">Il file è troppo grande (max 50MB)</x-error-message>
    <x-form-error :name="str_replace('[]', '', $name)" />
</div>

@pushOnce('scripts')
    @vite('resources/js/components/file-max-size.js')  
@endPushOnce