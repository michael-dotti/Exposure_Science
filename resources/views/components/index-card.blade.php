@props([
    'href',
    'title'
])

<article
    class="group relative overflow-hidden rounded-lg border border-white/10 bg-slate-800/40 shadow-sm transition duration-200 hover:border-blue-400/40 hover:bg-slate-800/60"
>
    <a
        href="{{ $href }}"
        class="absolute inset-0 z-10"
    ></a>

    <div class="pointer-events-none absolute bottom-0 left-0 top-0 w-1 bg-blue-500"></div>

    <div class="pointer-events-none relative z-20 flex flex-col sm:flex-row">

        <div class="flex items-center justify-center border-b border-white/10 bg-slate-900/30 p-4 sm:w-48 sm:border-b-0 sm:border-r">
            {{ $image }}
        </div>

        <div class="min-w-0 flex-1 p-4">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                <div class="min-w-0">

                    <h2 class="text-lg font-bold text-white transition group-hover:text-blue-300">
                        {{ $title }}
                    </h2>

                    {{ $people ?? '' }}

                </div>

                {{ $badge ?? '' }}

            </div>

            {{ $details ?? '' }}

            @isset($description)
                <p class="mt-3 max-w-full break-words text-sm leading-5 text-gray-400 [overflow-wrap:anywhere]">
                    {{ $description }}
                </p>
            @endisset

            <div class="pointer-events-auto relative z-30 mt-4 flex flex-wrap items-center gap-2 border-t border-white/10 pt-3">

                {{ $actions ?? '' }}

                <span class="pointer-events-none ml-0 text-xs font-semibold text-blue-400 sm:ml-auto">
                    Visualizza dettagli →
                </span>

            </div>

        </div>

    </div>

</article>