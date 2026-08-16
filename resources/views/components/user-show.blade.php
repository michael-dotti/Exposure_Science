@props([
    'user', 
    'showButtons' => false, // Di default i bottoni si vedono, ma puoi disabilitarli
    'isUserManagement' => false
])

<div {{ $attributes->merge(['class' => 'mt-3 w-full']) }}>
    <div class="mx-auto w-full max-w-4xl space-y-6 text-white">
        
        {{-- Header --}}
        <div class="border-b border-white/10 pb-4">
            <div class="flex justify-between items-center w-full my-4">
                <div>
                    <h1 class="text-base/7 font-bold text-white">
                        Qui puoi trovare le informazioni personali
                    </h1>
                </div>
                <div>
                    <x-link-button href="{{ url()->previous() }}">Indietro</x-link-button>
                </div>
            </div>
        </div>

        {{-- Contenuto Dati Utente --}}
        <div class="space-y-6">
            <div>
                <p class="text-base/7 font-bold text-white">Il tuo nominativo: </p>
                <p class="text-base/7 text-white ml-8"> {{ $user->name }} {{ $user->surname }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">La tua e-mail: </p>
                <p class="text-base/7 text-white ml-8"> {{ $user->email }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">La tua bio: </p>
                <p class="text-base/7 text-white ml-8"> {{ $user->bio ?? '[Nessuna bio inserita]' }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">Il tuo sito web: </p>
                @if ($user->website)    
                    <a class="text-cyan-400 transition duration-200 hover:text-cyan-600 ml-8" href="{{ $user->website }}" target="_blank"> 
                        {{ $user->website }} 
                    </a>
                @else
                    <p class="text-base/7 text-gray-500 ml-8 italic"> [non hai inserito nessun sito a tuo nome] </p>
                @endif

                <p class="text-base/7 font-bold text-white mt-2">Il tuo CV:</p>
                @if ($user->curriculum)
                    <x-button-open-file :file="$user->curriculum" class="ml-8"/>
                @else
                    <p class="text-base/7 text-gray-500 ml-8 italic"> [non hai inserito nessun CV a tuo nome] </p>
                @endif
            </div>
            @if ($isUserManagement)
                <p class="text-base/7 font-bold text-white mt-2">Ruoli assegnati: </p>
                <div class="text-base/7 text-white ml-8">
                    @forelse ($user->display_roles as $role)
                        @if ($loop->first)
                            <div class="flex flex-wrap gap-2">
                        @endif
                                <x-role-badge :role="$role" />
                        @if ($loop->last)
                            </div> 
                        @endif
                    @empty
                        <span class="text-gray-500 italic">[Nessun ruolo assegnato]</span>
                    @endforelse
                </div>
            @endif
            <div>
                <p class="text-base/7 font-bold text-white">La tua immagine profilo: </p>
                <img src="{{ $user->profilePhotoUrl }}" alt="profile_photo" class="rounded-full w-32 h-32 object-cover ml-8 mt-2">
            </div>
        </div>
    </div>

    {{-- Footer con Bottoni Opzionali --}}
    @if ($showButtons)
        <div class="mx-auto mt-6 flex w-full max-w-4xl items-center justify-end gap-x-3 border-t border-white/10 py-5">
            @if (isset($buttons))
                {{-- Se passi uno slot <x-slot:buttons>, mostra quello --}}
                {{ $buttons }}
            @else
                {{-- Comportamento di default se non passi nessuno slot --}}
                <a href="{{ route('admin.users.edit', $user) }}">
                    <x-save-button type="button">MODIFICA DATI</x-save-button>
                </a>
            @endif
        </div>
    @endif
</div>