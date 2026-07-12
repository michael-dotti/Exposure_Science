<x-layout-menu-bar-public>
    <x-slot:title>
        Member
    </x-slot:title>
    <x-slot:heading>
        {{ $user->name }} {{ $user->surname }}
    </x-slot:heading>
    <div>
        <div class="flex h-screen items-center justify-center bg-gray-900">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <h2 class="mb-6 font-bold text-white">{{ $user->bio }}</h2>
            </div>
            <div>
                <img src="{{ $user->profilePhotoUrl }}" alt="{{ $user->name }}" class="md:size-96 size-72 rounded-full " />
            </div>
            </div>
        </div>
    </div>

    
</x-layout-menu-bar-public>