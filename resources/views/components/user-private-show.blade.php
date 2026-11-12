@props([
    'user', 
    'isPersonal' => false, // stabilisce se ci troviamo nella pagina personale o nello show di gestisci utenti e cambia di conseguenza il testo da mostrare
    'roles' => [] // Necessario quando isPersonal è false per generare le checkbox dei ruoli
])

<div {{ $attributes->merge(['class' => 'mt-3 w-full']) }}>
    <div class="mx-auto w-full max-w-4xl space-y-6 text-white">  
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
                <p class="text-base/7 text-white ml-8">{{ $user->name }} {{ $user->surname }}</p>
                
                <p class="text-base/7 font-bold text-white mt-2">{{ $isPersonal ? 'La tua e-mail:' : 'E-mail:' }}</p>
                <p class="text-base/7 text-white ml-8">{{ $user->email }}</p>
                
                <p class="text-base/7 font-bold text-white mt-2">{{ $isPersonal ? 'La tua bio:' : 'Bio:' }}</p>
                <p class="text-base/7 text-white ml-8">{{ $user->bio ?? '[Nessuna bio inserita]' }}</p>
                
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

    {{-- Sezione Azioni / Footer --}}
    <div class="mx-auto w-full max-w-4xl">
        @if ($isPersonal)
            {{-- Pagina Personale: Modifica Informazioni Personali --}}
            <div class="mt-6 flex items-center justify-end gap-x-3 border-t border-white/10 py-5">
                <x-modify-button-link href="{{ route('admin.users.edit', $user->id) }}">
                    Modifica Dati
                </x-modify-button-link>
            </div>
        @else
            {{-- Vista Gestione Utenti: Cambia Ruolo All'utente --}}
            @if (auth()->id() !== $user->id)
                <div class="mt-8 border-t-4 border-white/60 pt-6">
                    <x-form-layout :button_back="false" method="PATCH" action="{{ route('admin.users-management.update', $user->id) }}" :divider="false">
                        <x-slot:header>
                            <h2 class="text-xl font-bold text-amber-500">
                                Modifica i ruoli di {{ $user->name }} {{ $user->surname }}
                            </h2>
                        </x-slot:header>

                        <x-content-section>
                            <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                                @foreach ($roles as $role)
                                    <x-role-checkbox 
                                        :role="$role" 
                                        :isEdit="true"
                                        :user="$user" 
                                    />
                                @endforeach
                            </div>
                        </x-content-section>

                        <x-slot:buttons>
                            <x-save-button type="submit">
                                Salva
                            </x-save-button>
                            <a href="{{ url()->previous() }}">
                                <x-danger-button type="button">
                                    Annulla
                                </x-danger-button>
                            </a>   
                        </x-slot:buttons>
                    </x-form-layout>
                </div>
            @endif
        @endif
    </div>
</div>