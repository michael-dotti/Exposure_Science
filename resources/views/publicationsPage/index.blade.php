<x-layout-menu-bar>
    <x-slot:title>
        Publications
    </x-slot:title>
    <x-slot:heading>
        Publications Page
    </x-slot:heading>
    <div>
        <table>
        @foreach ($articles as $artile)
            <tr> <td class="font-semibold text-white"> {{ $artile->title }} </td> </tr>
        @endforeach
    </div>
</x-layout-menu-bar>