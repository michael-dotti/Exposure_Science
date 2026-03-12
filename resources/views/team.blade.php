<x-layout-menu-bar>
    <x-slot:title>
        Team
    </x-slot:title>
    <x-slot:heading>
        Team Page
    </x-slot:heading>
        <div class="flex h-full items-start justify-start bg-gray-50 pl-5 ">
            <div class="w-full md:w-1/2 rounded-lg bg-white px-8 py-4 shadow-md m-4">
                <div class="px-1 py-4">
                    <h3 class="font-bold text-2xl font-sans">Our incredible team</h3>
                </div>
                <ul class="grid grid-cols-4 gap-2 px-1">
                    @foreach ($users as $user )
                    <li class="flex items-center flex-col">
                        <img src="{{ $user->profile_photo_path }}" alt="profile_photo" class="rounded-full w-16 h-16 object-cover">
                        <h5 class="font-semibold">{{ $user->name }} {{ $user->surname }}</h5>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>


    <div class="flex h-screen items-center justify-center bg-gray-50">
        <div class="w-full md:w-1/2 rounded-lg bg-white px-8 py-4 shadow-md m-4">
            <div class="px-1 py-4">
                <h3 class="font-bold text-2xl font-sans">Our incredible team</h3>
            </div>
            <ul class="grid grid-cols-4 gap-2 px-1">
                @foreach ($users as $user )
                <li class="flex items-center flex-col">
                    <div class="relative flex w-full max-w-[26rem] flex-col rounded-xl bg-transparent bg-clip-border text-gray-700 shadow-none">
                        <div class="relative mx-0 mt-4 flex items-center gap-4 overflow-hidden rounded-xl bg-transparent bg-clip-border pt-0 pb-8 text-gray-700 shadow-none">
                            <img
                            src="{{ $user->profile_photo_path}}"
                            alt="{{ $user->name }} {{ $user->surname }}"
                            class="relative inline-block h-[58px] w-[58px] !rounded-full object-cover object-center"
                            />
                            <div class="flex w-full flex-col gap-0.5">
                            <div class="flex items-center justify-between">
                                <h5 class="block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                               {{ $user->name }} {{ $user->surname }}
                                </h5>
                            </div>
                            <p class="block font-sans text-base font-light leading-relaxed text-blue-gray-900 antialiased">
                                *role in the research group 
                            </p>
                            </div>
                        </div>
                        <div class="mb-6 p-0">
                            <p class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
                            "{{ $user->bio }}"
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    


</x-layout-menu-bar>