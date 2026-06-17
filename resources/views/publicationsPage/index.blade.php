<x-layout-menu-bar-public>
    <x-slot:title>
        Publicazioni
    </x-slot:title>
    <x-slot:heading>
        Publicazioni
    </x-slot:heading>
    <div class="relative z-10 flex flex-col justify-center items-center text-center text-white">
        
        <!-- filtraggio per titolo (NON FUNZIONANTE) -->
        <form action="/publications/search" class="border-2 border-white" method="get">
                <input type="text" placeholder="Cerca Articoli..."
                       name="title" id='title'>
                <button>
                    <i class="bg-white text-black"> cerca </i>
                </button>
        </form>

        <!--filtraggi-->
        <div class="flex space-x-2 my-4">
            <x-user-filter href="/publications" :users="$users"></x-user-filter>
            <x-research-area-filter href="/publications" :researchAreas="$areas"></x-research-area-filter>     
        </div>

        <!--esposizione articoli-->
        <div class="w-full max-w-7xl mx-auto text-white grid grid-cols-2 gap-2">
        @forelse ($articles as $article)
            <div class="bg-[#101828] border-2 border-black transition delay-10 duration-300 ease-in-out hover:-translate-y-1 hover:bg-[#161e2e]">
                <a href="publications/{{ $article->id }}"> {{ $article->title }} </a>
                <p> <small>{{ $article->abstract }}</small> </p>
                @if($article->image_path)
                    <div class="flex justify-center"> 
                        <img src="{{ Storage::url($article->image_path) }}" alt="profile_photo" class="w-16 h-16 object-cover">
                    </div>
                @endif
                <small> Autori: @foreach($article->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach </small>
                <div>
                    <small> Area:  {{ $article->researchAreas->pluck('name')->join(', ') }}  </small>
                </div>
            </div>
        @empty
            <div class="col-span-full w-full h-full">
            <x-message-of-empty title="Nessun articolo trovato"></x-message-of-empty>
            </div>
        @endforelse
        </div>
    </div>
    
    <div class="mt-2">
        {{ $articles->links() }}
    </div>
</x-layout-menu-bar-public>