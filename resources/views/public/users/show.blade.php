<x-layout-public>
    <x-slot:title>
        Member
    </x-slot:title>
    <x-slot:heading>
        {{ $user->name }} {{ $user->surname }}
    </x-slot:heading>

    <!-- Contenitore principale centrato nella pagina -->
    <div class="max-w-5xl mx-auto w-full px-4 py-8 flex flex-col gap-8">
        
        <!-- Box Profilo -->
        <div class="bg-gray-900 rounded-xl p-6 md:p-10 shadow-lg">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10">
                <div class="shadow-xl/20 shadow-gray-800">
                    <h1 class="mb-1 font-bold text-white">Ruolo</h1>
                    <p class="mt-1 mb-6 ml-6 font-medium text-amber-400">
                        @if ($user->hasRole('admin'))
                            Team Leader
                        @else
                            Membro del Team
                        @endif
                    </p>
                    <h1 class="mb-1 font-bold text-white">Descrizione</h1>
                    <p class="mb-4 ml-6 font-medium text-white">{{ $user->bio }}</p>
                </div>
                <!-- Immagine centrata all'interno della sua colonna -->
                <div class="flex justify-center">
                    <img src="{{ $user->profilePhotoUrl }}" alt="{{ $user->name }}" class="md:size-50 size-50 rounded-full object-cover" />
                </div>
            </div>
        </div>

        <!-- Box Contatti centrato rispetto alla pagina -->
        <div class="flex justify-center">
            <div class="rounded-md bg-gray-800 p-6 w-full max-w-lg text-center">
                <h2 class="bg-gray-900 rounded-md p-3 text-xl font-bold text-white">
                    CONTATTI
                </h2>
                <hr class="w-48 my-4 h-1 mx-auto bg-neutral-quaternary border-0 rounded-sm">
                <h3 class="text-lg text-white mx-2 leading-relaxed">
                    <b> E-MAIL: </b> {{ $user->email }}
                
                    @if ($user->website)
                        <br> <b> WEBSITE: </b> 
                        <a
                            class="text-cyan-400 transition duration-200 hover:text-cyan-600"
                            href="{{ $user->website }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        > 
                            {{ $user->website }} 
                        </a>
                    @endif
                </h3>
            </div>
        </div>
        
    </div>
</x-layout-public>
