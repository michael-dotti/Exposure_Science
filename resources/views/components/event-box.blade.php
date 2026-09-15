@props(['event', 'prevEventId' => null, 'nextEventId' => null, 'totalEvents' => 0, 'currentPage' => 0, 'baseRoute'])

<div class="mt-4 w-full flex-1 bg-slate-800 shadow-xl rounded-lg flex flex-col overflow-hidden border border-mist-600">
    
    <div class="min-h-16 py-3 px-4 flex flex-wrap items-center justify-between border-b gap-4 border-white/10 bg-slate-700 shrink-0">
        
        <div class="flex flex-wrap gap-2">
            {{ $buttons }}
        </div>
        
        @if($totalEvents > 1)
            @include('partials.event-show-pagination')
        @endif
    </div>

    <div class="flex-1 bg-slate-800 p-6 overflow-y-auto custom-scrollbar">
        {{ $slot }}
    </div>
</div>
