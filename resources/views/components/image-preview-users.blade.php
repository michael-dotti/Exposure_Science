@props(['name'=>'', 'currentImage' => null])

<div class="font-sans max-w-200 flex flex-col">

    {{-- Preview container --}}
    <div class="w-32 h-32 overflow-hidden border-3 border-solid border-white/20 rounded-full mt-2  flex justify-center">
        <img class="size-full max-h-100 shadow-sm object-cover" 
       src="{{ $currentImage }}"  {{--  significato " A ?? B" -> se A != null fai A, altrimenti fai B --}}
       alt="Preview Image" 
        id="image_preview"> 
    </div>

    {{-- File Input --}}
    <div class="flex flex-row items-center gap-3 mt-4">
        <x-input-image :name="$name"/>
        <input type="hidden" name="remove_photo" id="remove_photo" value="0"/> {{-- serve per gestire il caso in cui l'utente voglia eliminare l'immagine dal database --}}
        <x-danger-button type="button" id="deleteButton">
            Elimina
        </x-danger-button>
    </div>
</div>

@pushOnce('scripts')
    @vite('resources/js/components/image-preview-users.js')  
@endPushOnce
