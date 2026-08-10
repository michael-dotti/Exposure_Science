@props(['file','text'=>null, 'buttonText' => 'Download'])

<x-primary-link-button
    :text="$text"
    :href="route('files.download', $file)"
    :title="$file->file_name" {{-- Testo che appare quando appoggi il muose sul componente --}}
    icon="fa-solid fa-download"
    {{ $attributes }}
>
    {{ $buttonText }}
</x-primary-link-button>
