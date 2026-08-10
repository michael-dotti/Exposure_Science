{{-- componente per mostrare un file --}}
@props(['file', 'text'=>null, 'buttonText' => 'Apri'])

<x-primary-link-button
    :text="$text"
    :href="route('files.show',$file->id)"
    :title="$file->file_name"
    icon="fa-solid fa-arrow-up-right-from-square"
    target="_blank"
    {{ $attributes }} 
>
    {{ $buttonText }}
</x-primary-link-button>