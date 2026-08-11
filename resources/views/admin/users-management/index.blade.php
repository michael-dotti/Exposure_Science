<x-layout-private>
    <x-slot:title>
        Gestione Utenti 
    </x-slot:title>
    <div class="bg-gray-50 dark:bg-gray-900 flex flex-col flex-1 w-full min-h-[calc(100vh-3.5rem)]">
        <div class="w-full flex flex-col flex-1 min-h-0">
            
            <div class="relative flex flex-col flex-1 bg-white shadow-md dark:bg-gray-800 overflow-hidden">
                
                <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4 shrink-0">
                    <div class="flex items-center flex-1 space-x-4">
                        <h5 class="text-white">Ecco tutti i tuoi collaboratori</h5>
                    </div>
                    <div class="flex flex-col shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        <x-button-create href="{{ route('admin.users-management.create') }}">Aggiungi Ricercatore</x-button-create>
                    </div>
                </div>

                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nome</th>
                                <th scope="col" class="px-4 py-3">Ruolo/i</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $users as $user )
                            {{-- onclick="window.location='URL'"== una volta cliccato sull'elemento spostati sulla pagina con url URL --}}
                                <tr class="cursor-pointer border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-profile-foto-mini src="{{ $user->profilePhotoUrl }}" class="mr-1"/>
                                        {{ $user->name }} {{ $user->surname }}
                                    </th>
                                    <td class="px-4 py-2">
                                       <div class="flex flex-wrap gap-2">
                                            @foreach ($user->display_roles as $role)
                                                <x-role-badge :role="$role" />
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{-- azioni --}}
                                        <div class="flex gap-2">
                                            <x-view-button-link href="{{ route('admin.users-management.show',$user->id) }}">Gestisci</x-view-button-link>
                                            <div>
                                                @if(auth()->id() != $user->id)
                                                    <x-danger-button  data-modal-target="deleteModal" data-modal-toggle="deleteModal">elimina</x-danger-button>
                                                    <x-confirm-delete-modal id="deleteModal-{{ $user->id }}" form="delete-form-{{ $user->id }}">
                                                        Sei sicuro di voler eliminare l'utente {{ $user->name }} {{ $user->surname }}?
                                                    </x-confirm-delete-modal>
                                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users-management.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty 
                            {{-- Senza tr e td il contenuto di <tbody> non appare correttamente --}}
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center">
                                        <x-message-of-empty title="Errore: nessun ricercatore trovato" image="fa-regular fa-envelope"></x-message-of-empty>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $users->links('partials.custom-pagination') }} {{-- Dico a Laravel di non utilizzare al paginazione custom per "$users", ma quella custom creata da me in: partials.custom-pagination --}}
            </div>
        </div>
    </div>
    
</x-layout-private>