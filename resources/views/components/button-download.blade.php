@props(['file'])

<a href="{{ route('files.download', $file) }}" 
    title="{{ $file->file_name }}"
    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow transition"> 
    <i class="fa-solid fa-download w-4 h-4 fill-current shrink-0"></i>
    Download
</a>