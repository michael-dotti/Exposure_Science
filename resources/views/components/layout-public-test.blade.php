@props(['fullWidth' => false])

<!DOCTYPE html>
<html class="h-full bg-gray-900" lang="it" class="dark"> {{-- di default in dark mode --}}
  <head>
    <title>{{ $title }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    @livewireStyles 
    {{-- necessario insieme a @livewireScripts, in fondo al tag <body></body>, per caricare Alpine --}}
  </head>
  
  <body class="h-full">

    <nav class="bg-gray-800 fixed w-full z-20 top-0 inset-s-0 border-b border-gray-900/50">
        <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="shrink-0 flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/LogoUniversitaBrescia.webp') }}" alt="Your Company" class="h-10 w-24 bg-white/70 backdrop-blur-md rounded-sm border-2 border-white/40 shadow-2xl" />
            </div>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    @guest
                    <a href="/login">
                      <i class="fa-regular fa-user"></i>
                    </a>
                    @endguest
                    @auth
                     <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom"></button></button>
                        <a href="/admin/users/show">
                          <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profilePhotoUrl }}" alt="user photo">
                        </a>
                      </button>
                    @endauth    
                <span class="sr-only">Open user menu</span>
                    
                
                <!-- Dropdown menu -->
                 @auth
                <div class="z-50 hidden bg-gray-800 border border-gray-900/50 rounded-base shadow-lg w-44" id="user-dropdown">
                    <div class="px-4 py-3 text-sm border-b border-gray-900/50">
                      <span class="block text-heading font-medium">{{ auth()->user()->name }} {{ auth()->user()->surname }}</span>
                      <span class="block text-body truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Earnings</a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Sign out</a>
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
              <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                <li>
                  <a href="#" class="block py-2 px-3 text-white bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0" aria-current="page">Home</a>
                </li>
                <li>
                  <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About</a>
                </li>
                <li>
                  <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Services</a>
                </li>
                <li>
                  <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Pricing</a>
                </li>
                <li>
                  <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Contact</a>
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