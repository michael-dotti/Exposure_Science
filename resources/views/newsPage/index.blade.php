<x-layout-menu-bar-public>
    <x-slot:title>
        Novità
    </x-slot:title>
    <x-slot:heading>
        Novità
    </x-slot:heading>

    <div class="text-white grid grid-cols-2 gap-2">
        @foreach ($news as $n)
            <div class="bg-[#101828] border-2 border-black transition delay-10 duration-300 ease-in-out hover:-translate-y-1 hover:bg-[#161e2e]">
                <a href="news/{{ $n->id }}"> {{ $n->title }} </a>
                <p> <small>{{ $n->abstract }}</small> </p>
                @if($n->imagePath)
                    <div class="flex justify-center"> 
                        <img src="{{ Storage::url($n->imagePath) }}" alt="profile_photo" class="w-16 h-16 object-cover">
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</x-layout-menu-bar-public>