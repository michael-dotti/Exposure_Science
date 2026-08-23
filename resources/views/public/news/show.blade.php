<x-layout-public>
    <x-slot:title>
        {{ $n->title }}
    </x-slot:title>
    <x-slot:heading>
        <div class="text-white text-3xl"> {{ $n->title }} </div>
        <pre class="text-sm"> del <span class="text-orange-400"> {{ date('Y-m-d', strtotime($n->created_at)) }} <span> </pre>
    </x-slot:heading>
    <div>
        <div class="flex h-screen items-center justify-center bg-gray-900 p-5">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
            <div>
                <p class="mb-6 font-bold text-white">{!! $n->content !!}</p>

            </div>
            <div class="mb-6 text-small text-white">
                <img src="{{ Storage::url($n->image_path) }}" alt="{{ $n->title }}" class="md:size-96 size-72" />
            </div>
            </div>
        </div>
    </div>
</x-layout-public>