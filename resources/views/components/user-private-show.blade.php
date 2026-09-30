@props([
    'user', 
    'showButtons' => false, // Di default i bottoni si vedono, ma puoi disabilitarli
    'isPersonal' => false // stabilisce se ci troviamo nella pagina personale o nello show di gestisci utenti e cambia di conseguenza il testo da mostrare
])

<div {{ $attributes->merge(['class' => 'mt-3 w-full']) }}>
    <div @class([
        'mx-auto w-full max-w-4xl space-y-6 text-white',
        'pb-12' => !$showButtons // Aggiunge padding in basso se i bottoni sono disabilitati
    ])>
        
        {{-- Header --}}
        <div class="border-b border-white/10 pb-4">
            <div class="flex justify-between items-center w-full my-4">
                <div>
                    <h1 class="text-base/7 font-bold text-white">
                        {{ $isPersonal ? 'Qui puoi trovare le tue informazioni personali' : 'Informazioni di ' . $user->name . ' ' . $user->surname }}
                    </h1>
                </div>
                @if(!$isPersonal)
                    <x-private-button-back />
                @endif
            </div>
        </div>

        {{-- Contenuto Dati Utente --}}
        <div class="space-y-6">
            <div>
                <p class="text-base/7 font-bold text-white">{{ $isPersonal ? 'Il tuo nominativo:' : 'Nominativo:' }}</p>
                <p class="text-base/7 text-white ml-8"> {{ $user->name }} {{ $user->surname }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">{{ $isPersonal ? 'La tua e-mail:' : 'E-mail:' }}</p>
                <p class="text-base/7 text-white ml-8"> {{ $user->email }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">{{ $isPersonal ? 'La tua bio:' : 'Bio:' }}</p>
                <p class="text-base/7 text-white ml-8"> {{ $user->bio ?? '[Nessuna bio inserita]' }} </p>
                
                <p class="text-base/7 font-bold text-white mt-2">{{ $isPersonal ? 'Il tuo sito web:' : 'Sito web:' }}</p>
                @if ($user->website)    
                    <a class="text-cyan-400 transition duration-200 hover:text-cyan-600 ml-8" href="{{ $user->website }}" target="_blank"> 
                        {{ $user->website }} 
                    </a>
                @else
                    <p class="text-base/7 text-gray-500 ml-8 italic">
                        {{ $isPersonal ? '[non hai inserito nessun sito a tuo nome]' : '[nessun sito web inserito]' }}
                    </p>
                @endif

                <p class="text-base/7 font-bold text-white mt-2">
                    {{ $isPersonal ? 'Il tuo CV:' : 'Curriculum Vitae:' }}
                </p>
                
                @if ($user->curriculum)
                    <x-button-open-file :file="$user->curriculum" class="ml-8"/>
                @else
                    <p class="text-base/7 text-gray-500 ml-8 italic">
                        {{ $isPersonal ? '[non hai inserito nessun CV a tuo nome]' : '[nessun CV inserito]' }}
                    </p>
                @endif
                
            </div>

            {{-- I ruoli dell'utente --}}
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
                        <span class="bg-white/10 text-heading text-sm font-medium px-2 py-1 rounded">Ricercatore Base</span>
                @endforelse
            </div>
           
            <div>
                <p class="text-base/7 font-bold text-white">{{ $isPersonal ? 'La tua immagine profilo:' : 'Immagine profilo:' }}</p>
                <img src="{{ $user->profilePhotoUrl }}" alt="profile_photo" class="rounded-full w-32 h-32 border-3 border-white/20 object-cover ml-8 mt-2">
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
                <x-modify-button-link
                    href="{{ route('admin.users.edit', $user->id) }}"
                >
                    Modifica Dati
                </x-modify-button-link>
            @endif
        </div>
    @endif
</div>