<x-layout-menu-bar-public>
  <x-slot:title>
        Home
    </x-slot:title>
    <x-slot:heading>
        Home
    </x-slot:heading>

    <div class="relative bg-linear-to-r from-purple-600 to-blue-600 h-screen text-white overflow-hidden flex flex-col">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/homePage.webp') }}" alt="Background Image" class="object-cover object-center w-full h-full" />
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>

    <!-- Main Content (Titolo e Sottotitolo) -->
    <!-- flex-grow fa sì che questa parte occupi tutto lo spazio disponibile, spingendo il footer in basso -->
    <div class="z-10 flex flex-col grow justify-center items-center text-center px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">
            Benvenuti nel nostro meraviglioso sito
        </h1>
        <p class="mt-4 text-lg md:text-2xl text-gray-200 max-w-2xl mx-auto drop-shadow-md">
            Per conoscere e far conoscere.
        </p>
    </div>
    
    <!-- Footer -->
    <footer class="z-10 bg-black/30 backdrop-blur-md p-6 w-full border-t border-white/10">
        <div class="max-w-7xl mx-auto flex flex-nowrap flex-col md:flex-row justify-between items-end gap-8">
            
            <!-- Indirizzo -->
            <div class="text-left min-w-50">
                <h3 class="font-bold text-xl mb-2 border-b border-white/30">Contatti</h3>
                <p>Via Roma, 123</p>
                <p>00100 Roma (RM)</p>
                <p>Email: info@esempio.it</p>
            </div>

            
            <!-- News -->
            <div class="grow">
                @if($news)
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach ($news as $n)
                            <div class="bg-[#253041]/80 border border-gray-500 rounded-lg p-3 flex-1 gap-2 transition hover:-translate-y-1">
                                <a href="/news/{{ $n->id }}" class="font-bold text-sm hover:text-blue-400 transition"> 
                                    {{ $n->title }} 
                                
                                
                                <div class="h-24 overflow-hidden rounded">
                                    <img src="{{ Storage::url($n->imagePath) }}" alt="news_image" class="w-full h-full object-cover">
                                </div>

                                <p class="text-xs text-gray-300">
                                    <span class="text-orange-400 font-semibold">{{ $n->publicationDate }}</span>
                                    {{ Str::limit($n->content, 60) }}
                                </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </footer>
</div>
</x-layout-menu-bar>