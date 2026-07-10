@props(['files'])
<div class="border-t-2 border-white/10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 py-4">
    @foreach ( $files as $file)
        <x-attachment-card :file="$file"/>
    @endforeach  
</div>