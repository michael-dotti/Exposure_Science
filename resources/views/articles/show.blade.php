<x-layout-menu-bar-user>
    <x-slot:title>
        Article
    </x-slot:title>
    
    <h1 class="text-lg text-left text-red-500 hover:bg-black block absolute">Article Name: {{ $article->title }}</h1>
    
    <div class="flex justify-end">
        <x-link-button href="/articles" >back</x-link-button>
    </div>
    
</x-layout-menu-bar-user>