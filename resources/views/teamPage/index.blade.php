<x-layout-menu-bar-public>
    <x-slot:title>
        Team
    </x-slot:title>
    <x-slot:heading>
        Team
    </x-slot:heading>
        <div class="flex h-full items-start justify-start pl-5 ">
            <div class="w-full md:w-1/2 rounded-lg  px-8 py-4 m-4">
                <div class="px-1 py-4">
                    <h3 class="font-bold text-2xl font-sans text-amber-300">Il nostro megamastico e fantasmagorico Team:</h3>
                </div>
                <ul class="grid grid-cols-4 gap-2 px-1">
                    @foreach ($users as $user )
                    <li>
                        <a class="flex items-center flex-col" href="teamPage/{{ $user->id }}">
                            <img src="{{ $user->profilephotourl }}" alt="profile_photo" class="rounded-full w-16 h-16 object-cover">
                            <h5 class="font-semibold text-white">{{ $user->name }} {{ $user->surname }}</h5>
                            <h6 class="text-sm text-white">@if ( $user->admin)
                            Team Leader
                            @endif</h6>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
</x-layout-menu-bar-public>