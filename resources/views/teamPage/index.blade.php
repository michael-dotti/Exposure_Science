<x-layout-menu-bar-public>
    <x-slot:title>
        Team
    </x-slot:title>
    <x-slot:heading>
         <h3 class="font-bold text-2xl font-sans text-amber-300">Il nostro meraviglioso Team</h3>
    </x-slot:heading>

    <div class="flex h-full items-start justify-start">
        <div class="w-full md:w-2/3 rounded-lg">
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                @foreach ($users as $user )
                    <li class="flex flex-col items-start text-center">
                        <a class="items-center" href="teamPage/{{ $user->id }}">
                            <img src="{{ $user->profilephotourl }}" alt="profile_photo" class="rounded-full w-16 h-16 object-cover mx-auto">
                            <h5 class="font-semibold text-white mt-2">{{ $user->name }} {{ $user->surname }}</h5>
                            @if ( $user->hasRole('admin'))
                                <h6 class="text-sm text-amber-400 font-medium mt-0.5">Team Leader</h6>
                            @endif  
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout-menu-bar-public>