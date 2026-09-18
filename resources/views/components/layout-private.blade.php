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
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-56 h-screen transition-transform -translate-x-full sm:translate-x-0 flex flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-900/50" aria-label="Sidenav">
        
        <div class="flex items-center justify-center h-16 bg-cordes-blue shrink-0 shadow-xl z-10">
            <div class="flex items-center justify-center h-16 bg-cordes-blue">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-cordes-blue text-lg"></i>
                    </div>
                    <span class="text-white text-xl font-bold">Dashboard</span>
                </div>
            </div>
        </div>

        <div class="overflow-y-auto py-5 px-3 flex-1">
            <ul class="space-y-2">
                <li>
                    <x-link-with-icon href="{{ route('admin.users.show') }}" :active="request()->routeIs('admin.users.*')" iconType="fas fa-user">Area Personale</x-link-with-icon>
                </li>
                <li>
                    <x-link-with-icon href="{{ route('admin.articles.index') }}" :active="request()->routeIs('admin.articles.*')" iconType="fas fa-book">Articoli</x-link-with-icon>
                </li>
                <li>
                    <x-link-with-icon href="{{ route('admin.projects.index') }}" :active="request()->routeIs('admin.projects.*')" iconType="fas fa-chart-bar">Progetti</x-link-with-icon>
                </li>
                @can('teaching')
                    <li>
                        <x-link-with-icon href="{{ route('admin.courses.index') }}" :active="request()->routeIs('admin.courses.*')" iconType="fa-solid fa-person-chalkboard">Corsi</x-link-with-icon>
                    </li>
                @endcan
                <li>
                    <x-link-with-icon href="{{ route('admin.events.index') }}" :active="request()->routeIs('admin.events.*')" iconType="fas fa-cube">Eventi</x-link-with-icon>
                </li>
                @can('management news')
                    <li>
                        <x-link-with-icon href="{{ route('admin.news-management.index') }}" :active="request()->routeIs('admin.news-management.*')" iconType="fas fa-newspaper">Gestisci news</x-link-with-icon>
                    </li>
                @endcan
                @can('management events')
                    <li>
                        <x-link-with-icon href="{{ route('admin.events-management.index') }}" :active="request()->routeIs('admin.events-management.*')" iconType="fas fa-cubes"> Gestisci Eventi</x-link-with-icon>
                    </li>
                @endcan
                @can('management users')
                    <li>
                        <x-link-with-icon href="{{ route('admin.users-management.index') }}" :active="request()->routeIs('admin.users-management.*')" iconType="fas fa-users">Gestisci Utenti</x-link-with-icon>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="flex justify-center p-4 w-full shrink-0">
            <div class="bg-gray-800 rounded-lg p-3 flex flex-col gap-3 items-center">
                
                {{-- Sezione Nome e Foto Utente --}}
                <div class="flex items-center space-x-3">
                    <x-profile-foto-mini />
                    <div>
                        <p class="text-white text-sm font-medium">
                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
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
                            <i class="fa-solid fa-arrow-up ml-1"></i>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('public.home') }}">Home</x-dropdown-link>
                        <x-dropdown-link href="{{ route('profile.show') }}">Impostazioni avanzate</x-dropdown-link>
                        <div class="border-t border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="sm:ml-56 bg-cordes-dark min-h-screen">
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
