<x-layout-menu-bar-private>
    <x-slot:title>
        Visualizza Notizia <span class="text-yellow-400">{{ $news->title }}</span> del {{ $news->created_at->format('d/m/Y') }}
    </x-slot:title>
    <p class="text-white">Prova</p>
</x-layout-menu-bar-private>