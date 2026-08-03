@props(['file','text'])

@if ($text)
    <p class="text-white font-medium mb-2 mt-2">{{ $text }}</p>
@endif
<a href="{{ route('files.download', $file) }}" 
    title="{{ $file->file_name }}"
    class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg shadow transition"> 
    <i class="fa-solid fa-download w-4 h-4 fill-current shrink-0"></i>
    Download
</a>