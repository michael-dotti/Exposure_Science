<x-layout-menu-bar>
  <x-slot:title>
        Home
    </x-slot:title>
    <x-slot:heading>
        Home Page
    </x-slot:heading>

    <div class="relative bg-linear-to-r from-purple-600 to-blue-600 h-screen text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/homePage.webp') }}" alt="Background Image" class="object-cover object-center w-full h-full" />
            <div class="absolute inset-0 bg-black opacity-50">{{-- Eventuale testo davanti all'immagine in background --}}</div>
        </div>
  
        <div class="relative z-10 flex flex-col my-20 mbs-20">
            <div class="justify-center items-center text-center h-full">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">Welcome to Our Awesome Website</h1>
                <p class="mt-4 text-lg md:text-2xl text-gray-200 max-w-2xl mx-auto drop-shadow-md">Discover amazing features and services that await you.</p>
            </div>
            <div class="text-white grid grid-cols-3 gap-2 mbs-20">
                @foreach ($news as $n)
                    <div class="justify-center text-center border border-2 border-black  bg-[#177013] rounded-md">
                        <a href="news-and-events"> {{ $n->titolo }} </a>
                        <hr class="bg-[#5a7059] h-px border-0"></hr>
                        @if(strlen($n->contenuto) > 67)
                            <div> {{ substr($n->contenuto, 0, 67) . "..." }} </div>
                        @else
                            <div> {{ $n->contenuto }} </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout-menu-bar>