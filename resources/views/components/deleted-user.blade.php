@props([
    'size' => 'size-10',
    'iconSize' => 'text-base',
    'text' => 'Utente rimosso'
])

<div class="{{ $size }} rounded-full bg-red-500 border border-slate-600 flex items-center justify-center mr-2 text-white shrink-0">
    <i class="fa-solid fa-user-xmark {{ $iconSize }}"></i>
</div>
<span class="truncate text-sm font-semibold text-gray-400 italic">
    {{ $text }}
</span>