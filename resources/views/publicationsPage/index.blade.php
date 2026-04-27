<x-layout-menu-bar>
    <x-slot:title>
        Publications
    </x-slot:title>
    <x-slot:heading>
        Publications Page
    </x-slot:heading>
    <div class="relative z-10 flex flex-col justify-center items-center text-center">
        <table>
        @foreach ($articles as $article)
            <tr>
                <td class="font-semibold text-white">
                    <a href="publications/{{ $article->id }}"> {{ $article->title }} </a>
                </td>
                <td class="text-white">
                    <p> <small>{{ $article->abstract }}<small> </p>
                </td>
            </tr>
            <tr>
                <td> <img src="{{ asset($article->image_path) }}" alt="profile_photo" class="w-16 h-16 object-cover"> </td>
                <td> </td>
            </tr>
        @endforeach
    </div>
</x-layout-menu-bar>