@props(['role'])

@switch($role)
    @case('projects manager')
        <span class="bg-neutral-primary-soft text-heading text-sm font-medium px-2 py-1 rounded">Gestore Progetti</span>
        @break

    @case('projects admin')
        <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 text-sm font-medium px-2 py-1 rounded">Amministratore Progetti</span>
    @break
    
    @case('news manager')
        <span class="bg-brand-softer text-fg-brand-strong text-sm font-medium px-2 py-1 rounded">Gestore Notizie</span>
        @break

    @case('teacher')
        <span class="bg-success-soft text-fg-success-strong text-sm font-medium px-2 py-1 rounded">Docente</span>
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

