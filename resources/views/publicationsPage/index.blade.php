<x-layout-menu-bar-public>
    <x-slot:title>
        Publicazioni
    </x-slot:title>
    <x-slot:heading>
        Publicazioni
    </x-slot:heading>
    <div class="relative z-10 flex flex-col justify-center items-center text-center text-white">
        
        <!-- filtraggio per titolo (NON FUNZIONANTE) -->
        <div> <br> </div>
        <form action="/publications/search" class="border-2 border-white" method="get">
                <input type="text" placeholder="Cerca Articoli..."
                       name="title" id='title'>
                <button>
                    <i class="bg-white text-black"> cerca </i>
                </button>
            </form>
        <div> <br> </div>

        <!--filtraggi-->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        <div class="flex space-x-2 mb-4">
            <!-- filtraggio per autore-->
            <el-dropdown class="inline-block">
            <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20">
                Seleziona autore
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
            </button>

            <el-menu anchor="bottom end" popover class="w-56 origin-top-right divide-y divide-white/10 rounded-md bg-gray-800 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
            <div class="py-1">    
                <a href="/publications" class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white"> Tutti </a>
            </div>
            <div class="py-1">
                @foreach ($users as $user)
                    <a href="/publications/author/{{ $user->id }}" class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white"> {{ $user->name }} {{ $user->surname }} </a>
                @endforeach
            </div>
            </el-menu>
            </el-dropdown>


            <!-- filtraggio per area di ricerca -->
            <el-dropdown class="inline-block">
            <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20">
                Seleziona per area di ricerca
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
            </button>

            <el-menu anchor="bottom end" popover class="w-56 origin-top-right divide-y divide-white/10 rounded-md bg-gray-800 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
            <div class="py-1">
                <a href="/publications" class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white"> Tutte </a>
            </div>
            <div class="py-1">
                @foreach ($areas as $area)
                    <a href="/publications/researchAreas/{{ $area->id }}" class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white"> {{ $area->name }}  </a>
                @endforeach
            </div>
            </el-menu>
            </el-dropdown>
        </div>

        <!--esposizione articoli-->
        <div class="text-white grid grid-cols-2 gap-2">
        @foreach ($articles as $article)
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
        @endforeach
        </div>
    </div>
    
    <div class="mt-2">
        {{ $articles->links() }}
    </div>
</x-layout-menu-bar-public>