@props(['events','event'])

<div class="w-full flex-1 bg-mist-700 shadow-xl rounded-lg flex flex-col overflow-hidden border border-mist-600">
    
    <div class="min-h-16 py-3 px-4 flex flex-wrap items-center justify-between border-b gap-4 border-white/10 bg-mist-700 shrink-0">
        
        <div class="flex flex-wrap gap-2">
            {{ $buttons }}
        </div>
        
        @if($events->hasPages())
            {{ $events->links('partials.event-show-pagination') }}
        @endif
    </div>

    <div class="flex-1 bg-mist-700 p-6 overflow-y-auto custom-scrollbar">
        {{ $slot }}
    </div>
</div>
