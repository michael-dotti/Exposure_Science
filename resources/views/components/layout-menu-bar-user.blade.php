<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-cordes-dark shadow-xl z-50">
        <div class="flex items-center justify-center h-16 bg-cordes-blue">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-cube text-cordes-blue text-lg"></i>
                </div>
                <span class="text-white text-xl font-bold">Dashboard</span>
            </div>
        </div>
        
        <nav class="mt-8 px-4">
            <div class="space-y-2">
                <a href="/dashboard" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('dashboard')" class="fas fa-user"></x-icon-dashboard>
                    Area Personale {{-- TODO: l'utente può cambiare foto profilo, nome, breve descrizione di se ecc... --}}
                </a>
                <a href="/articles" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('articles')" class="fas fa-book"></x-icon-dashboard>
                    Articoli
                </a>
                <a href="/project" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('projects')" class="fas fa-chart-bar"></x-icon-dashboard>
                    progetti
                    {{-- 
                    TODO:la pagina caricata varia in base al fatto se l'utente è:
                    NO AMMINISTRATORE: vede i progetti assegnatigli
                    AMMINISTRATORE: vede i progetti assegnatigli e ne può creare dei nuovi, potendo volendo 
                    collegare il progetto ad un evento per degli altri utenti
                    --}}
                </a>
                <a href="/events" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('events')" class="fas fa-cube"></x-icon-dashboard>
                    Eventi
                    {{-- 
                    TODO:la pagina caricata varia in base al fatto se l'utente è:
                    NO AMMINISTRATORE: vede gli eventi rivolti a lui
                    AMMINISTRATORE: vede gli eventi rivolti a lui e ne può creare dei nuovi 
                    --}}
                </a>
                {{-- 
                    TODO: se l'utente è amministratore avrà anche le sezioni qui sotto 
                    TODO: IMPLEMENTARE VERIFICA UTENTE AMMINISTRATORE (con "can"?)--}}
                <a href="/user-management" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('user-management')" class="fas fa-users"></x-icon-dashboard>
                    Gestisci Utenti
                </a>
                <a href="/news-management" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('news-management')" class="fas fa-newspaper"></x-icon-dashboard>
                    Gestisci news
                </a>
                <a href="/event-management" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group">
                    <x-icon-dashboard :active="request()->is('news-management')" class="fas fa-cubes"></x-icon-dashboard>
                    Gestisci Eventi
                </a>
            </div>
        </nav>
        
        {{-- Nome Utente --}}
        <div class="absolute bottom-4 left-4 right-4">
            <div class="bg-gray-800 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-white text-sm font-medium">{{ Auth::user()->name }} {{Auth::user()->surname }} </p>
                        @if(auth()->user()->admin)
                            <p class="text-gray-400 text-xs">Administrator</p>
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 bg-cordes-dark min-h-screen">
        <!-- Top Header -->
        <header class="bg-cordes-dark border-b border-white/10">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-white">{{ $title }} Page</h1>
                    </div>
                </div>
            </div>
        </header>

    <div class="px-6"> 
    {{ $slot }}
    </div>  
</body>
</html>