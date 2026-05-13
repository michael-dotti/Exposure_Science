<x-layout-menu-bar-public>
  <x-slot:title>
        Home
    </x-slot:title>
    <x-slot:heading>
        Home
    </x-slot:heading>

    <div class="relative bg-linear-to-r from-purple-600 to-blue-600 h-screen text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/homePage.webp') }}" alt="Background Image" class="object-cover object-center w-full h-full" />
            <div class="absolute inset-0 bg-black opacity-50">{{-- Eventuale testo davanti all'immagine in background --}}</div>
        </div>
  
        <div class="z-10 flex flex-col my-20 mbs-20">
            <div class="justify-center items-center text-center h-full">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">Benvenuti nel nostro meraviglioso sito</h1>
                <p class="mt-4 text-lg md:text-2xl text-gray-200 max-w-2xl mx-auto drop-shadow-md">Per conoscere e far conoscere.</p>
            </div>
            <div class="absolute inset-x-0 bottom-0 text-white grid grid-cols-3 gap-2 mbs-20">
                @foreach ($news as $n)
                    <div class="text-center border-2 border-black  bg-[#177013] rounded-md">
                        <a href="news"> {{ $n->title }} </a>
                        <hr class="bg-[#5a7059] h-px border-0"></hr>
                        @if($n->imagePath)
                            <div class="flex justify-center"> 
                                <img src="{{ Storage::url($n->imagePath) }}" alt="profile_photo" class="object-contain">
                            </div>
                        @endif
                        <hr class="bg-[#5a7059] h-px border-0"></hr>
                            <p>
                                <span style="color:rgb(255, 99, 71)"> {{ $n->publicationDate }} </span>
                                @if(strlen($n->content) > 67)
                                    {{ ": " . substr($n->content, 0, 67) . "..." }}
                                @else
                                    {{ ": " . $n->content }}
                                @endif
                            </p>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout-menu-bar>