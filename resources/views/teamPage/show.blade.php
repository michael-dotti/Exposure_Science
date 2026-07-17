<x-layout-menu-bar-public>
    <x-slot:title>
        Member
    </x-slot:title>
    <x-slot:heading>
        {{ $user->name }} {{ $user->surname }}
    </x-slot:heading>

    <div>
        <div class="items-center justify-center bg-gray-900">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
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
            <div>
                <img src="{{ $user->profilePhotoUrl }}" alt="{{ $user->name }}" class="md:size-96 size-72 rounded-full " />
            </div>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="rounded-md bg-gray-800
                p-2">
                    <h2 class="bg-gray-900
                    rounded-md p-3
                    text-xl font-bold text-white">
                        CONTATTI
                    </h2>
                    <hr class="w-48 my-3 h-1 mx-auto bg-neutral-quaternary border-0 rounded-sm">
                    <h3 class="text-l text-white mx-2">
                        <b> E-MAIL: </b> {{ $user->email }}
                    
                        @if ($user->website)
                            <br> <b> WEBSITE: </b> <a
                                class="text-cyan-400
                                transition duration-200
                                hover:text-cyan-600"
                                href="{{ $user->website }}"
                            > {{ $user->website }} </a>
                        @endif

                        <!-- TODO: implementare la possibilità di inserire un numero di telefono-->
                        <br> <b> TELEFONO: </b> 0364 420 6969
                    </h3>
            </div>
        </div>
    </div>

    
</x-layout-menu-bar-public>