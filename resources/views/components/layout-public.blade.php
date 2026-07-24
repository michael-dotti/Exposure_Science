@props(['fullWidth' => false])

<!DOCTYPE html>
<html class="h-full bg-gray-900" lang="it" class="dark"> {{-- di default in dark mode --}}
  <head>
    <title>{{ $title }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    @livewireStyles 
    {{-- necessario insieme a @livewireScripts, in fondo al tag <body></body>, per caricare Alpine --}}
  </head>
  
  <body class="h-full">

    <nav class="bg-gray-800 fixed w-full z-20 top-0 inset-s-0 border-b-4 border-gray-900/50">
        <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="shrink-0 flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/LogoUniversitaBrescia.webp') }}" alt="Your Company" class="h-10 w-24 bg-white/70 backdrop-blur-md rounded-sm border-2 border-white/40 shadow-2xl" />
            </div>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    @guest
                    <a href="/login">
                      <i class="fa-regular fa-user text-white"></i>
                    </a>
                    @endguest
                    @auth
                      <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-white/10" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profilePhotoUrl }}" alt="user photo">
                      </button>
                    @endauth    
                
                    
                
                <!-- Dropdown menu -->
                 @auth
                <div class="z-50 hidden bg-gray-700 border border-white/10 rounded-base shadow-lg w-44" id="user-dropdown">
                    <div class="px-4 py-3 text-sm border-b border-white/10">
                      <span class="block text-gray-100 font-medium">{{ auth()->user()->name }} {{ auth()->user()->surname }}</span>
                      <span class="block text-gray-400 truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="p-2 text-sm text-gray-200 font-medium" aria-labelledby="user-menu-button">
                        <li>
                            <a href="/admin/users/show" class="inline-flex items-center w-full p-2 hover:bg-gray-800 rounded">Profilo</a>
                        </li>
                        <li>
                            <a href="/admin/articles" class="inline-flex items-center w-full p-2 hover:bg-gray-800 rounded">articoli</a>
                        </li>
                        <li>
                            <a href="/admin/events" class="inline-flex items-center w-full p-2 hover:bg-gray-800 rounded">eventi</a>
                        </li>
                        @can('teaching')
                          <li>
                            <a href="/admin/courses" class="inline-flex items-center w-full p-2 hover:bg-gray-800 rounded">Corsi</a>
                          </li>
                        @endcan
                        <li>
                            <form method="POST" action="{{ route('logout') }}" x-data> {{-- l'helper {{ route('logout') }} genera in automatico l'URL corretto per la rotta logout--}}
                                @csrf
                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="inline-flex items-center w-full p-2 hover:bg-gray-800 rounded">Log out</a>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth   
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
              <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-white/10 rounded-base bg-gray-800 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-border-white/10">
                <li>
                  <x-nav-link href="/" :active="request()->is('/')" >Home</x-nav-link>
                <li>
                   <x-nav-link href="/public/users" :active="request()->is('public/users*')" >Team</x-nav-link>
                </li>
                <li>
                  <x-nav-link href="/public/articles" :active="request()->is('public/articles*')">Publicazioni</x-nav-link>
                </li>
                <li>
                   <x-nav-link href="/public/news" :active="request()->is('public/news*')" >Novità</x-nav-link>
                </li>
                <li>
                   <x-nav-link href="/public/courses" :active="request()->is('public/courses*')" >Corsi</x-nav-link>
                </li>
                <li>
                  <x-nav-link href="/public/projects" :active="request()->is('public/projects*')" >Progetti</x-nav-link>
                </li>
              </ul>
            </div>
        </div>
      </nav>


        <header class=" pt-16 relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-white ">{{ $heading }}</h1>
        </div>
      </header>
      <main>
        @if ($fullWidth)
          {{ $slot }}
        @else
          {{-- Div con class dimensione massima e padding-y: max-w-7xl py-6 --}}
        <div class="mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8">
          {{ $slot }}
        </div>
        @endif
        
      </main>
    @livewireScripts 
    {{-- necessario insieme a @livewireStyles, nel tag <head>, per caricare Alpine --}}

    {{-- @stack('script') lo usiamo per permettere ad una view che utilizza questo script di aggiungere uno script di javascript --}}
    @stack('script')
    </body>
</html>