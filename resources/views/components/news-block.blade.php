@props([
    'n',
    'hrefShow',
    'showDate' => false,
])

<a
    href="{{ $hrefShow }}"
    class="group flex h-full flex-col overflow-hidden rounded-xl border border-white/10 bg-slate-800/50
           shadow-lg transition duration-300 hover:-translate-y-1 hover:border-amber-400/40 hover:bg-gray-700
           hover:shadow-2xl"
>
    <div class="aspect-video w-full overflow-hidden bg-gray-900">

        @if ($n->image_path)

            <img
                src="{{ Storage::url($n->image_path) }}"
                alt="{{ $n->title }}"
                loading="lazy"
                class="h-full w-full object-cover object-center transition duration-500
                       group-hover:scale-105"
            >

        @else

            <div class="flex h-full w-full flex-col items-center justify-center bg-gray-900 text-gray-500">
                <i
                    class="fa-regular fa-newspaper text-4xl"
                    aria-hidden="true"
                ></i>

                <span class="mt-3 text-xs font-medium">
                    Nessuna immagine
                </span>
            </div>

        @endif

    </div>

    <div class="flex flex-1 flex-col px-4 py-3">

        @if ($showDate)
            <span class="mb-1 block text-xs font-semibold text-orange-400">
                {{ $n->created_at->format('d/m/Y') }}
            </span>
        @endif

        <h3
            class="mt-2 line-clamp-2 min-h-[3.5rem]break-words text-2xl font-bold leading-7 text-white transition-colors group-hover:text-amber-300"
        >
            {{ $n->title }}
        </h3>

        <div
            class="mt-auto flex items-center justify-end gap-2 pt-4 text-sm font-semibold text-cyan-400"
        >
            <span>
                Leggi la novità
            </span>

            <i
                class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"
                aria-hidden="true"
            ></i>
        </div>

    </div>
</a>