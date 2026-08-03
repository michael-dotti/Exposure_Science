<x-layout-public>
    <x-slot:title>
        Publicazioni
    </x-slot:title>
    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                Le nostre publicazioni
            </h1>

            <p class="max-w-2xl mx-auto mt-3 text-base text-gray-300">
                Scopri come la scienza ogni giorno avanza.
            </p>
        </div>
    </x-slot:heading>

    <div class="relative z-10 flex flex-col justify-center items-center text-center text-white">

        <!--filtraggi-->
        <div class="flex space-x-2 my-4">
            <x-user-filter href="/public/articles" :users="$users"></x-user-filter>
            <x-research-area-filter href="/public/articles" :researchAreas="$areas"></x-research-area-filter>     
        </div>

        <!--esposizione articoli-->
        @if ($articles->isEmpty())
            <div class="w-full max-w-7xl mx-auto px-4 bg-transparent">
                <x-message-of-empty title="Nessun articolo trovato"></x-message-of-empty>
            </div>
        @else
            <div class="w-full max-w-7xl mx-auto text-white grid grid-cols-2 gap-2">
                @foreach ($articles as $article)
                    <a href="{{ route('public.articles.show',$article->id) }}" class="block h-full">
                        <div class="rounded-md bg-gray-800 border-2 border-black transition delay-10 duration-300 ease-in-out hover:-translate-y-1 hover:bg-gray-700 *:m-3">
                            <p class="text-center">{{ $article->title }} </p>
                            <p class="h-12 overflow-hidden text-center text-sm">
                                {!! \Illuminate\Support\Str::limit(
                                    strip_tags($article->abstract),
                                    150
                                ) !!}
                            </p>
                            @if($article->image_path)
                                <div class="flex justify-center"> 
                                    <img src="{{ Storage::url($article->image_path) }}" alt="profile_photo" class="w-16 h-16 object-cover">
                                </div>
                            @else
                                {{-- Segnaposto opzionale: se l'immagine manca, manteniamo lo spazio --}}
                                <div class="h-16 w-16 mx-auto"></div>
                            @endif
                            
                            <div class="flex flex-col mt-auto">
                                <small> Autori: @foreach($article->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach </small>
                                <small> Area:  {{ $article->researchAreas->pluck('name')->join(', ') }}  </small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    
    <div class="mt-2">
        {{ $articles->links() }}
    </div>
</x-layout-public>