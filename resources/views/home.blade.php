<x-layout-menu-bar>
  <x-slot:title>
        Home
    </x-slot:title>
    <x-slot:heading>
        Home Page
    </x-slot:heading>

    <div class="relative bg-gradient-to-r from-purple-600 to-blue-600 h-screen text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/homePage.webp') }}" alt="Background Image" class="object-cover object-center w-full h-full" />
            <div class="absolute inset-0 bg-black opacity-50">{{-- Eventuale testo davanti all'immagine in background --}}</div>
        </div>
  
        <div class="relative z-10 flex flex-col justify-center items-center h-full text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">Welcome to Our Awesome Website</h1>
            <p class="mt-4 text-lg md:text-2xl text-gray-200 max-w-2xl mx-auto drop-shadow-md">Discover amazing features and services that await you.</p>
        </div>
    </div>
    
    
</x-layout-menu-bar>