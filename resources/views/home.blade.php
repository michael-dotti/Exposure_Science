<x-layout-menu-bar-public :fullWidth="true">
  <x-slot:title>
        Home
    </x-slot:title>
    <x-slot:heading>
        Home
    </x-slot:heading>

    <div class="relative h-screen text-white overflow-hidden flex flex-col">
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
    <footer class="z-10 bg-black/30 backdrop-blur-md p-3 md:p-6 w-full border-t border-white/10">
        <div class="max-w-7xl mx-auto flex flex-nowrap flex-col md:flex-row justify-between items-end gap-4 md:gap-8">
            
            <div class="text-left min-w-50 hidden md:block">
                <h3 class="font-bold text-xl mb-2 border-b border-white/30">Contatti</h3>
                <p>Via Roma, 123</p>
                <p>00100 Roma (RM)</p>
                <p>Email: info@esempio.it</p>
            </div>

            <div class="grow w-full">
                @if($news)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                        @foreach ($news as $n)
                            <div class="relative overflow-hidden border border-gray-500 rounded-lg flex-1 transition hover:-translate-y-1 h-32 md:h-auto md:bg-[#253041]/80 md:p-3">
                                
                                <div class="absolute inset-0 md:hidden bg-cover bg-center" 
                                    style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.9)), url('{{ Storage::url($n->imagePath) }}');">
                                </div>

                                <a href="/public/news/{{ $n->id }}" class="relative z-10 flex flex-col justify-end md:justify-start h-full p-3 md:p-0">
                                    
                                    <span class="font-bold text-sm text-white hover:text-blue-400 transition mb-1 md:mb-0"> 
                                        {{ $n->title }} 
                                    </span> 
                                    
                                    <div class="h-24 overflow-hidden rounded hidden md:block my-2">
                                        <img src="{{ Storage::url($n->imagePath) }}" alt="news_image" class="w-full h-full object-cover">
                                    </div>

                                    <p class="text-xs text-gray-300 mt-auto md:mt-0">
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