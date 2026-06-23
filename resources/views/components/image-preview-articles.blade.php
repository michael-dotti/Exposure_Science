@props(['name' => '', 'currentImage' => null])

@php
    // Otteniamo l'URL che Laravel genera quando non c'è nessun file (es. "/storage")
    $emptyStorageUrl = Storage::url('');

    // L'immagine è valida SOLO SE:
    // 1. Non è vuota
    // 2. Non è l'URL del sito
    // 3. Non è il percorso "vuoto" dello storage (es. "/storage" o "/storage/")
    $isValidImage = !empty($currentImage) && 
                    $currentImage !== url('/') && 
                    $currentImage !== asset('') && 
                    $currentImage !== $emptyStorageUrl && 
                    $currentImage !== rtrim($emptyStorageUrl, '/');
@endphp

<div class="my-2 font-sans max-w-200 flex flex-col gap-4">

    {{-- File Input --}}
    <div class="justify-start rounded-sm flex items-center gap-2">
        <x-input-image :name="$name"/>
        
        <input type="hidden" name="remove_photo" id="remove_photo" value="0"/> 
        
        {{--il Pulsante Elimina --}}
        <div id="deleteButtonWrapper" class="{{ $isValidImage ? '' : 'hidden' }}">
            <x-danger-button type="button" id="deleteButton">
                Elimina
            </x-danger-button>
        </div>
    </div>

    {{-- Preview container --}}
    <div id="previewContainer" class="{{ $isValidImage ? '' : 'hidden' }} w-48 h-48 overflow-hidden border-4 border-solid flex justify-center">
        <img class="size-full max-h-100 shadow-sm object-cover" 
             src="{{ $currentImage ?? '' }}" 
             alt="Preview Image" 
             id="image_preview"> 
    </div>
    
</div>

@pushOnce('scripts')
    @vite('resources/js/components/image-preview-article.js')  
@endPushOnce