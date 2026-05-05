<x-layout-menu-bar>
    <x-slot:title>
        Publications
    </x-slot:title>
    <x-slot:heading>
        Publications Page
    </x-slot:heading>
    <div class="relative z-10 flex flex-col justify-center items-center text-center text-white">
        <div> <br> </div>
        <form action="/publications/search" class="border border-2 border-white" method="get">
                <input type="text" placeholder="Cerca Articoli..."
                       name="title" id='title'>
                <button>
                    <i class="bg-white text-black"> cerca </i>
                </button>
            </form>
        <div> <br> </div>
        <div class="text-white grid grid-cols-2 gap-2">
        @foreach ($articles as $article)
            <div class="border border-2 border-black">
                <a href="publications/{{ $article->id }}"> {{ $article->title }} </a>
                <p> <small>{{ $article->abstract }}</small> </p>
                @if($article->image_path)
                    <div class="flex justify-center"> 
                        <img src="{{ Storage::url($article->image_path) }}" alt="profile_photo" class="w-16 h-16 object-cover">
                    </div>
                @endif
                <small> Autori: {{ $article->users->pluck('name')->join(', ') }} </small>
            </div>
        @endforeach
        </div>
    </div>
    <div>
        {{ $articles->links() }}
    </div>
</x-layout-menu-bar>