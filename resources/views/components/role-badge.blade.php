@props(['role'])

@switch($role)
    @case('articles admin')
        <span class="bg-yellow-700 text-yellow-200 text-sm font-medium px-2 py-1 rounded">Amministratore articoli</span>
        @break

    @case('projects manager')
        <span class="bg-pink-600 text-pink-200 text-sm font-medium px-2 py-1 rounded">Gestore Progetti</span>
        @break

    @case('projects admin')
        <span class="bg-violet-700 text-pink-200 dark:bg-violet-700 dark:text-pink-200 text-sm font-medium px-2 py-1 rounded">Amministratore Progetti</span>
    @break
    
    @case('events admin')
        <span class="bg-blue-700 text-sky-200 dark:bg-blue-700 dark:text-sky-200 text-sm font-medium px-2 py-1 rounded">Amministratore Eventi</span>
    @break

    @case('news manager')
        <span class="bg-sky-500 text-sky-100 text-sm font-medium px-2 py-1 rounded">Gestore Notizie</span>
        @break

    @case('teacher')
        <span class="bg-lime-800 text-lime-200 text-sm font-medium px-2 py-1 rounded">Docente</span>
        @break
    
    @case('courses admin')
        <span class="bg-green-800 text-lime-200 text-sm font-medium px-2 py-1 rounded">Amministratore Corsi</span>
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

