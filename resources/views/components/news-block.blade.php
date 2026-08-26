@props([
    'n',
    'hrefShow',
    'showDate' => false
])

<a
    href="{{ $hrefShow }}"
    class="group overflow-hidden rounded-xl border border-white/10 bg-slate-800/50 transition duration-300 hover:-translate-y-1 hover:border-blue-400/40 hover:bg-slate-800"
>
    <div class="aspect-video w-full overflow-hidden">
        @if($n->image_path)

            <img
                src="{{ Storage::url($n->image_path) }}"
                alt="{{ $n->title }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
            >

        @else

            <div class="flex h-full items-center justify-center bg-slate-800">
                <i class="fa-regular fa-newspaper text-4xl text-gray-500"></i>
            </div>

        @endif

    </div>
    <div class="mx-4 my-3">
        @if($showDate)
            <span class="text-orange-400 font-semibold text-xs block mb-1">
                {{ $n->created_at->format('d/m/Y') }}
            </span>
        @endif

        <h3 class="mt-2 text-2xl font-bold text-white transition group-hover:text-blue-300">
            {{ $n->title }}
        </h3>

        <div class="my-2 text-sm font-semibold text-blue-400">
            Leggi la novità →
        </div>
    </div>
</a>