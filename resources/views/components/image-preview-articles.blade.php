@props(['name' => '', 'currentImage' => null])

<div class="m-2 p-2 font-sans max-w-200 flex flex-col gap-4">

    {{-- File Input --}}
    <div class="justify-start bg-linear-to-bl from-violet-500 to-fuchsia-500 p-2 rounded-sm flex items-center gap-2">
        <input class="text-white border-2 border-solid rounded-sm cursor-pointer w-20 h-10" 
               type="file" 
               name="{{ $name }}" 
               id="imageUpload" 
               accept="image/*">
        
        <input type="hidden" name="remove_photo" id="remove_photo" value="0"/> 
        
        {{--il Pulsante Elimina --}}
        <div id="deleteButtonWrapper" class="hidden">
            <x-button type="button" id="deleteButton" class="bg-red-600 hover:bg-red-400">
                Elimina
            </x-button>
        </div>
    </div>

    {{-- Preview container --}}
    <div id="previewContainer" class="hidden w-48 h-48 overflow-hidden border-4 border-solid flex justify-center">
        <img class="size-full max-h-100 shadow-sm object-cover" 
             src="{{ $currentImage ?? '' }}" 
             alt="Preview Image" 
             id="image_preview"> 
    </div>
    
</div>

@pushOnce('scripts')
    @vite('resources/js/components/image-preview-article.js')  
@endPushOnce