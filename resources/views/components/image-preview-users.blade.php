@props(['name'=>'', 'currentImage' => null])

<div class=" font-sans max-w-200 flex flex-col">

    {{-- Preview container --}}
    <div class="w-32 h-32 overflow-hidden border-4 border-solid rounded-full mt-2 border-white flex justify-center">
        <img class="size-full max-h-100 shadow-sm object-cover" 
       src="{{ $currentImage }}"  {{--  significato " A ?? B" -> se A != null fai A, altrimenti fai B --}}
       alt="Preview Image" 
        id="image_preview"> 
    </div>

    {{-- File Input --}}
    <div class="justify-center mt-2 ml-5">
        <input class="text-white  border-2 border-solid rounded-sm cursor-pointer w-20 h-10 bg-linear-to-bl from-violet-500 to-fuchsia-500" 
        type="file" 
        name="{{ $name }}" 
        id="imageUpload" 
        accept="image/*">
        <input type="hidden" name="remove_photo" id="remove_photo" value="0"/> {{-- serve per gestire il caso in cui l'utente voglia eliminare l'immagine dal database --}}
        <x-button type="button" class="bg-red-600 hover:bg-red-400" id="deleteButton">Elimina</x-button>
    </div>
</div>

@pushOnce('scripts')
    @vite('resources/js/components/image-preview-users.js')  
@endPushOnce
