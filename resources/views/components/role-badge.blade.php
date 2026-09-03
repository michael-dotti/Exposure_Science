@props(['role'])

@switch($role)
    @case('articles admin')
    {{-- scegli 3 colori nuovi --}}
        <span class="bg-yellow-400 text-amber-700 text-sm font-medium px-2 py-1 rounded">Amministratore articoli</span>
        @break

    @case('projects manager')
        <span class="bg-pink-400 text-purple-800 text-sm font-medium px-2 py-1 rounded">Gestore Progetti</span>
        @break

    @case('projects admin')
        <span class="bg-violet-600 text-pink-400 dark:bg-violet-500 dark:text-purple-900 text-sm font-medium px-2 py-1 rounded">Amministratore Progetti</span>
    @break
    
    @case('events admin')
        <span class="bg-blue-600 text-sky-300 dark:bg-blue-600 dark:text-sky-300 text-sm font-medium px-2 py-1 rounded">Amministratore Eventi</span>
    @break

    @case('news manager')
        <span class="bg-sky-400 text-blue-700 text-sm font-medium px-2 py-1 rounded">Gestore Notizie</span>
        @break

    @case('teacher')
        <span class="bg-lime-400 text-green-800 text-sm font-medium px-2 py-1 rounded">Docente</span>
        @break
    
    @case('courses admin')
        <span class="bg-green-600 text-lime-300 text-sm font-medium px-2 py-1 rounded">Amministratore Corsi</span>
    @break
    
    @case('reliable researcher')
        <span class="bg-warning-soft text-fg-warning text-sm font-medium px-2 py-1 rounded">Ricercatore Affidabile</span>
        @break

    @case('admin')
        <span class="bg-danger-soft text-fg-danger-strong text-sm font-medium px-2 py-1 rounded">Admin</span>
        @break

    @default
        <span class="bg-white/10 text-heading text-sm font-medium px-2 py-1 rounded">Ricercatore Base</span>

@endswitch

