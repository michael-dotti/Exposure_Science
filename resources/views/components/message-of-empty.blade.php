@props([
    'title', 
    'image' => 'fa-regular fa-file-lines', 
    'description' => ''
])

<div class="text-center py-12 bg-slate-900/40 backdrop-blur-sm rounded-xl border-2 border-dashed border-slate-800/80 p-8 shadow-xl">
    
    {{-- Contenitore icona con un leggero accenno di colore --}}
    <div class=" inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/10 mb-4 text-blue-400">
        <i class="{{ $image }} text-3xl"></i>
    </div>
    
    {{-- Titolo Principale --}}
    <h3 class="text-base font-semibold text-slate-200 tracking-tight">{{ $title }}</h3>
    
    {{-- Descrizione opzionale --}}
    @if($description)
        <p class="mt-2 text-sm text-slate-400 max-w-sm mx-auto">{{ $description }}</p>
    @endif
    
    {{-- se inserisci qualcosa tra i tag del componente, apparirà qui --}}
    @if($slot->isNotEmpty())
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</div>