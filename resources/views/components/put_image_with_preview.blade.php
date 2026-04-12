{{--TODO: DA COMPLETARE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!--}}

<div class="m-2 p-2 font-sans max-w-200">

    {{-- Preview container --}}
    <div class="mt-1.5 p-1 border-2 border-dashed rounded-lg min-h-75 flex flex-col items-center justify-center">
        <img class="max-w-100% max-h-100 mt-1 rounded-sm shadow-sm " src="{{ auth()->user()->profile_photo_path != null   ? auth()->user()->profile_photo_path : asset('images/defaultUsers/no_image_user.webp') }}" alt="Preview Image" id="image_preview">
        {{-- più efficiente ma meno chiaro
        <img class="max-w-100% max-h-100 mt-1 rounded-sm shadow-sm " src="{{ auth()->user()->profile_photo_path ?? asset('images/defaultUsers/no_image_user.webp') }}" alt="Preview Image" id="image_preview">
        significato dei " A ?? B" -> se a != null fai A, altrimenti fai B 
        --}}
    </div>

    {{-- File Input --}}
    <input class="m-1 p-0.5 border-2 border-solid rounded-sm cursor-pointer" type="file" name="profile_photo_path" id="profile_photo_path" accept="image/*">
</div>

@pushOnce('scripts')
    @vite('resources/js/components/put_image_with_preview.js')  
@endPushOnce
