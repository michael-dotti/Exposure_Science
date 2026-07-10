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

<div class="w-full max-w-xs flex items-center justify-between p-2 border border-gray-300 rounded-lg hover:bg-mist-600 gap-2 transition-colors duration-200 ease-in-out">
    <div class="flex items-center min-w-0 gap-2">
        <img src="{{ asset($imagePath) }}" alt="File Extension" class="h-8 w-8 shrink-0">
        
        <div class="flex flex-col min-w-0">
            <a href="/attachment/{{ $file->id }}/download" class="text-sm text-gray-100 font-bold truncate" title="{{ $file->file_name }}">
                {{ $file->file_name }}
            </a>
            <span class="text-gray-300 text-xs">{{ $file->size_in_mb }} MB</span>
        </div>
    </div>
    
    <a href="/attachment/{{ $file->id }}/download" class="w-8 h-8 flex items-center justify-center shrink-0 text-gray-400 hover:text-gray-600" title="Download">
        <i class="fa-solid fa-download text-base"></i>
    </a>
</div>