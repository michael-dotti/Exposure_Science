@props([
    'role',
    'isEdit' => false, // determina se il checkbox si trova nella pagina create o edit, e in base a ciò fa eseguire una regola differente per decidere se il checbox dovrebbe essere già spuntato o meno 
    'user' => null, // Serve per leggere i ruoli se siamo in Edit
    ])

@php
    // Estraggo il nome e l'id del ruolo
    $roleName = $role->name;
    $roleId   = $role->id;

    // Se 'checked' non viene passato esplicitamente dall'esterno, usa la logica di Creazione
    $isChecked = old('_token') // true se l'utente non ha passato la validazione del form
        ? in_array($roleId, old('roles', [])) // verifica se l'utente (avendo fallito la validazione) aveva settato questo checkbox, altrimenti lo setta Null
        : ($isEdit && $user ? $user->hasRole($roleName) : $roleName === 'researcher'); // se $isEdit è true e $user contiene uno user ->regola edit, altrimenti ->regola Create
        // regola create: setta di default il ruolo "researcher" come già settato
        // regola edit: controllo che l'utente abbia questo ruolo 

    // Mappatura dei colori Flowbite e dell'etichetta in italiano
    [$colorClasses, $label] = match($roleName) {
        // Red / Danger
        'admin' => [
            'text-red-600 focus:ring-red-500 dark:focus:ring-red-600', 
            'Admin'
        ],
        // Green / Success
        'teacher' => [
            'text-green-600 focus:ring-green-500 dark:focus:ring-green-600', 
            'Docente'
        ],
        // Amber/Yellow / Warning
        'reliable researcher' => [
            'text-amber-500 focus:ring-amber-500 dark:focus:ring-amber-600', 
            'Ricercatore Affidabile'
        ],
        // Purple / Brand
        'news manager' => [
            'text-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600', 
            'Gestore Notizie'
        ],
        // Teal / Neutral Soft
        'projects manager' => [
            'text-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600', 
            'Gestore Progetti'
        ],
        // Gray / Mist / Default Base
        default => [
            'text-gray-500 focus:ring-gray-500 dark:focus:ring-gray-600', 
            'Ricercatore Base'
        ],
    };
@endphp

<div class="flex items-center me-4 py-1">
    <input
        id="role-{{ $roleId }}"
        name="roles[]"
        type="checkbox"
        value="{{ $roleId }}"
        @checked($isChecked)
        {{ $attributes->merge([
            'class' => "w-4 h-4 bg-neutral-secondary-medium border-default-medium rounded-xs ring-offset-neutral-primary focus:ring-2 " . $colorClasses
        ]) }}
    >
    <label for="role-{{ $roleId }}" class="select-none ms-2 text-sm font-medium text-heading cursor-pointer">
        {{ $label }}
    </label>
</div>