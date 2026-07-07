@props('files')
<div class="border-t-2 flex space-x-4 py-4">
    @foreach ( $files as $file)
        <x-attachment-card :file="$file"/>
    @endforeach  
</div>