@props(['role'])

@switch($role)
    @case('projects manager')
        <span class="bg-neutral-primary-soft text-heading text-sm font-medium px-2 py-1 rounded">Gestore Progetti</span>
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
        <span class="bg-mist-700 text-heading text-sm font-medium px-2 py-1 rounded">Ricercatore Base</span>

@endswitch

