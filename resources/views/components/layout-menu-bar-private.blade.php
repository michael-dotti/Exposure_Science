<!DOCTYPE html>
<html lang="it" class="dark"> {{-- di default in dark mode --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles 
    {{-- necessario insieme a @livewireScripts, in fondo al tag <body></body>, per caricare Alpine --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-cordes-dark min-h-screen">
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
                <x-link-with-icon href="/admin/users/show" :active="request()->is('admin/users/show')" iconType="fas fa-user">Area Personale</x-link-with-icon>
                <x-link-with-icon href="/admin/articles" :active="request()->is('/admin/articles*')" iconType="fas fa-book">Articoli</x-link-with-icon>
                <x-link-with-icon href="/admin/projects" :active="request()->is('admin/projects*')" iconType="fas fa-chart-bar">Progetti</x-link-with-icon>

                @can('teaching')
                    <x-link-with-icon href="/admin/courses" :active="request()->is('/admin/courses','/admin/courses/*')" iconType="fa-solid fa-person-chalkboard">Corsi</x-link-with-icon>
                @endcan()
                
                <x-link-with-icon href="/events" :active="request()->is('events','events/*')" iconType="fas fa-cube">Eventi</x-link-with-icon>
               
                @can('management users')             
                    <x-link-with-icon href="/users-management" :active="request()->is('users-management*')" iconType="fas fa-users">Gestisci Utenti</x-link-with-icon>
                @endcan
                @can('management news') 
                    <x-link-with-icon href="/news-management" :active="request()->is('news-management*')" iconType="fas fa-newspaper">Gestisci news</x-link-with-icon>
                @endcan
                @can('management events') 
                    <x-link-with-icon href="/events-management" :active="request()->is('events-management*')" iconType="fas fa-cubes"> Gestisci Eventi</x-link-with-icon>
                @endcan
            </div>
        </nav>
        
        <div class="flex w-full">
            {{-- Contenitore Utente e pulsanti --}}
            <div class="absolute bottom-4 left-4 right-4">
                <div class="bg-gray-800 rounded-lg p-3 flex flex-col gap-3 items-center">
                    
                    {{-- Sezione Nome e Foto Utente --}}
                    <div class="flex items-center space-x-3">
                        <x-profile-foto-mini />
                        <div>
                            <p class="text-white text-sm font-medium">
                                {{ Auth::user()->name }} {{Auth::user()->surname }} 
                            </p>
                            @role('admin')
                                <p class="text-gray-400 text-xs">Administrator</p>
                            @endrole
                        </div>
                    </div>
                    
                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <button class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-md flex items-center justify-center text-xs font-bold uppercase transition-colors">
                                Opzioni account
                                <i class="fa-solid fa-arrow-up"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="/">Home</x-dropdown-link>
                            <x-dropdown-link href="{{ route('profile.show') }}">Impostazioni avanzate</x-dropdown-link>

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}" x-data> {{-- l'helper {{ route('logout') }} genera in automatico l'URL corretto per la rotta logout--}}
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
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
                        <h1 class="text-2xl font-semibold text-white">{{ $title }} </h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="px-6 flex-1 flex flex-col overflow-hidden "> 
            {{ $slot }}
        </div>
    </div>
    @livewireScripts 
    {{-- necessario insieme a @livewireStyles, nel tag <head>, per caricare Alpine --}}
    
    @stack('scripts')
</body>
</html>