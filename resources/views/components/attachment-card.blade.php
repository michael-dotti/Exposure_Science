@props(['file'])
@php
    $imagePath = match($file->extension) {
        'doc', 'docx' => 'images/fileType/doc.svg',
        'jpg', 'jpeg', 'png', 'webp' => 'images/fileType/image.svg',
        'ppt', 'pptx' => 'images/fileType/ppt.svg',
        'txt' => 'images/fileType/txt.svg',
        'pdf' => 'images/fileType/pdf.svg',
        'xls', 'xlsx' => 'images/fileType/xls.svg',
        'zip', 'rar' => 'images/fileType/zip.svg',
        default => 'images/fileType/generic.svg', 
    };
@endphp

<div class="w-70 flex items-center py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200">
    <div class="flex items-center">
        <div class="w-10 flex items-center justify-center">
            <img src="{{ asset($imagePath) }}" alt="File Extension" class="h-8 w-8">
        </div>
        <div class="w-48 ml-2 flex flex-col">
            <a href="/attachment/{{ $file->id }}/download" class="text-sm text-gray-700 font-bold truncate">
                {{ $file->file_name }}
            </a>
            <span class="text-gray-500 text-xs">{{ $file->size_in_mb }} MB</span>
        </div>
    </div>
    <a href="/attachment/{{ $file->id }}/download" class="w-6 flex items-center justify-center" title="Download">
        <i class="fa-solid fa-download text-gray-500 hover:text-gray-600 h-6 w-6"></i>
    </a>
</div>