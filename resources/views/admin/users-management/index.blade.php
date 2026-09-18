<x-layout-private>
    <x-slot:title>
        Gestione Utenti 
    </x-slot:title>
    <div class="flex flex-col flex-1 w-full min-h-[calc(100vh-3.5rem)]">
        <div class="w-full flex flex-col flex-1 min-h-0 p-4 sm:p-6">
            
            <div class="relative flex flex-col flex-1 bg-white shadow-md dark:bg-slate-800 rounded-xl border border-transparent dark:border-slate-700/50 overflow-hidden">
                
                <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4 shrink-0">
                    <div class="flex items-center flex-1 space-x-4">
                        <h5 class="text-white">Ecco tutti i tuoi collaboratori</h5>
                    </div>
                    <div class="flex flex-col shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        <x-button-create href="{{ route('admin.users-management.create') }}">Aggiungi Ricercatore</x-button-create>
                        <x-user-status-filter />
                    </div>
                </div>

                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-sm table-auto text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-900/60 dark:text-gray-400 border-b border-gray-200 dark:border-slate-700/50">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-48 sm:w-60">Nome</th>
                                <th scope="col" class="px-4 py-3 w-48 hidden lg:table-cell">Ruolo/i</th>
                                <th scope="col" class="px-4 py-3 w-48 hidden md:table-cell">Email</th>
                                <th scope="col" class="px-4 py-3">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $users as $user )
                            {{-- onclick="window.location='URL'"== una volta cliccato sull'elemento spostati sulla pagina con url URL --}}
                                <tr class="border-b border-gray-100 dark:border-slate-700/50 transition-colors duration-150 {{ 
                                    $user->trashed() 
                                        ? 'bg-red-900/20 dark:bg-red-950/40 hover:bg-red-800/30 dark:hover:bg-red-900/40 opacity-80' 
                                        : 'hover:bg-gray-50 dark:hover:bg-slate-700/50' 
                                }}">
                                    <th scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white w-48 sm:w-60 align-middle">
                                        <div class="flex items-center min-w-0">
                                            <x-profile-foto-mini src="{{ $user->profilePhotoUrl }}" class="mr-1"/>
                                            <span class="truncate text-sm font-semibold">
                                                {{ $user->name }} {{ $user->surname }}
                                            </span>
                                        </div>
                                    </th>
                                    <td class="px-4 py-2 hidden lg:table-cell w-48">
                                       <div class="flex flex-wrap gap-1">
                                            @foreach ($user->display_roles as $role)
                                                <x-role-badge :role="$role" />
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 dark:text-white hidden md:table-cell w-48 align-middle">
                                        <span class="truncate max-w-48 lg:max-w-xs text-sm">
                                            {{ $user->email }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 dark:text-white align-middle">
                                        {{-- azioni --}}
                                        <div class="flex gap-2 items-center">
                                            @if ($user->trashed())
                                                <!-- Se è nel cestino mostro Ripristina e Elimina Definitivamente -->
                                                <x-button-blue type="submit" form="form-restore-{{ $user->id }}">Ripristina</x-button-blue>
                                                <x-danger-button data-modal-target="forceDeleteModal-{{ $user->id }}" data-modal-toggle="forceDeleteModal-{{ $user->id }}">Elimina Definitivamente</x-danger-button>
                                            @else
                                                <x-view-button-link href="{{ route('admin.users-management.show',$user->id) }}">Gestisci</x-view-button-link>
                                                <div>
                                                    @if(auth()->id() != $user->id)
                                                        <x-danger-button  data-modal-target="deleteModal-{{ $user->id }}" data-modal-toggle="deleteModal-{{ $user->id }}">elimina</x-danger-button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty 
                            {{-- Senza tr e td il contenuto di <tbody> non appare correttamente --}}
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center">
                                        <x-message-of-empty title="Nessun Ricercatore Trovato" image="fa-regular fa-envelope"></x-message-of-empty>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginazione --}}
                <div class="my-6 px-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    
    
    {{-- ZONA MODALI e form nascosti (i modali si trovano fuori dalla tabella per prevenire potenziali errori) --}} 
    @foreach ($users as $user)
        @if ($user->trashed())
            
            <!-- Ripristino (Niente modale, solo form nascosto collegato al bottone) -->
            <form action="{{ route('admin.users-management.restore', $user) }}" id="form-restore-{{ $user->id }}" method="POST" class="hidden">
                @csrf
                @method('PATCH')
            </form>

            <!-- Eliminazione Definitiva (Modale + Form) -->
            <form action="{{ route('admin.users-management.force-destroy', $user) }}" id="force-delete-form-{{ $user->id }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            <x-confirm-delete-modal modal_id="forceDeleteModal-{{ $user->id }}" form="force-delete-form-{{ $user->id }}" icon="fa-solid fa-circle-exclamation">
                Stai per eliminare definitivamente l'utente {{ $user->name }} {{ $user->surname }}?<br>
                Questa azione NON può essere annullata.
            </x-confirm-delete-modal>

        @else
            @if(auth()->id() != $user->id)
                
                <!-- Eliminazione Soft (Modale + Form) -->
                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users-management.destroy', $user->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                <x-confirm-delete-modal modal_id="deleteModal-{{ $user->id }}" form="delete-form-{{ $user->id }}">
                    Archiviare l'utente {{ $user->name }} {{ $user->surname }}?<br>
                    L'utente non potrà più accedere al sistema e verrà nascosto dall'elenco principale.<br> 
                    Potrai comunque visualizzarlo e ripristinarlo in qualsiasi momento dal filtro "Utenti Cestinati".
                </x-confirm-delete-modal>

            @endif
        @endif
    @endforeach
    
    <!-- <div class="my-6">
        {{ $users->links() }}
    </div> -->
</x-layout-private>