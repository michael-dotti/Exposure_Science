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

<div class="m-2 p-2 font-sans max-w-200 flex flex-col gap-4">

    {{-- File Input --}}
    <div class="justify-start bg-linear-to-bl from-violet-500 to-fuchsia-500 p-2 rounded-sm flex items-center gap-2">
        <input class="text-white border-2 border-solid rounded-sm cursor-pointer w-20 h-10" 
               type="file" 
               name="{{ $name }}" 
               id="imageUpload" 
               accept="image/*">
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
    @vite('resources/js/components/image-preview-news.js')  
@endPushOnce