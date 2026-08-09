{{-- Modale per mostrare un elenco degli utenti.
props:
- id = è l'id del modale a cui il bottone (che non si trova in questo componente) deve puntare, di default a 'usersModal'
- users = la collezione di user da msotrare
- modalTitle--}}
@props(['id'=>'usersModal', 'users', 'modalTitle'])


<!-- Main modal -->
<div id="{{ $id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    {{ $modalTitle }}
                </h3>
                <button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="{{ $id }}">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="space-y-4 md:space-y-6 py-4 md:py-6 grid grid-cols-3">
                @foreach ($users as $user)
                    <div class="flex ">
                        <x-profile-foto-mini src="{{ $user->profilePhotoUrl }}" class="float-right" />
                        <div class="flex flex-col ml-3 min-w-0">
                            <span class="text-sm text-gray-100 font-semibold">{{ $user->name}} {{ $user->surname}}</span>
                            <span class="text-xs text-gray-400">{{ $user->email }} </span>
                        </div>
                    </div>  
                @endforeach
            </div>
            
        </div>
    </div>
</div>
