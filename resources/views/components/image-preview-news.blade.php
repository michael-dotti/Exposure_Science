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

<div class="mb-2 font-sans w-full flex flex-col gap-3">

    {{-- File Input --}}
    <div class="justify-start rounded-sm flex items-center gap-2">
        <x-input-image :name="$name"/>
    </div>

    {{-- Preview container --}}
    <div id="previewContainer" class="{{ $isValidImage ? '' : 'hidden' }} w-full h-96 overflow-hidden border-2 border-solid border-white/20 flex items-center justify-center bg-slate-900/30">
        <img class="w-full h-full object-contain" 
             src="{{ $currentImage ?? '' }}" 
             alt="Preview Image" 
             id="image_preview"> 
    </div>
    
</div>

@pushOnce('scripts')
    @vite('resources/js/components/image-preview-news.js')  
@endPushOnce