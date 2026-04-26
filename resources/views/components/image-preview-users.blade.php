{{--TODO: da complerare, valutare come caricare URL dell'immagien di article --}} 


@props(['name'=>'', 'currentImage' => null])

<div class=" font-sans max-w-200 flex flex-col">

    {{-- Preview container --}}
    <div class="w-32 h-32 overflow-hidden border-4 border-solid rounded-full mt-2 border-white flex justify-center">
        <img class="size-full max-h-100 shadow-sm object-cover" 
       src="{{ $currentImage }}"  {{--  significato " A ?? B" -> se A != null fai A, altrimenti fai B --}}
       {{-- NOTA BENE: l'url $currentImage funziona anche quando l'immagine è in storage se 
       si usa l'accessor nel model --}} 
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
    </div>
</div>

@pushOnce('scripts')
    @vite('resources/js/components/put_image_with_preview.js')  
@endPushOnce
