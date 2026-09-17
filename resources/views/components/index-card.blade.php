@props([
    'href',
    'title',
    'description' => null, // può essere usato (preferibilmente) come "<x-slot:description>..." oppure come ':description="..."' (in quel caso non servirebbero le graffe e i !!)
    'descriptionLimit' => 180,
    'imageWidth' => 'sm:w-48', // dimensione di default dell'immagine
    'flushImage' => false // Se true, toglie il padding per far espandere l'immagine
])

@php
    $formattedDescription = null;

    if ($description) {
        // Rimuove i tag HTML dell'editor Quill
        $cleanText = strip_tags((string) $description);

        // Se descriptionLimit è valorizzato, applica Str::limit
        $formattedDescription = $descriptionLimit 
            ? \Illuminate\Support\Str::limit($cleanText, $descriptionLimit) 
            : $cleanText;
    }
@endphp

<article
   class="group relative flex overflow-hidden rounded-lg border border-white/10 bg-slate-800/40 shadow-sm transition duration-200 hover:border-blue-400/40 hover:bg-slate-800/60"
>
    <a
        href="{{ $href }}"
        class="absolute inset-0 z-10"
    ></a>

    <div class="w-1.5 shrink-0 bg-blue-500 transition-colors group-hover:bg-blue-400"></div>

    <div class="pointer-events-none relative z-20 flex flex-1 flex-col sm:flex-row w-full">

        <div class="relative flex shrink-0 items-center justify-center overflow-hidden border-b border-white/10 bg-slate-900/30 {{ $imageWidth }} {{ $flushImage ? 'min-h-40 sm:min-h-full' : 'p-4' }} sm:border-b-0 sm:border-r">
            {{ $image }}
        </div>

        <div class="min-w-0 flex-1 p-4">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                <div class="min-w-0">

                    <h2 class="text-lg font-bold text-white transition group-hover:text-blue-300 wrap-break-word line-clamp-2 min-w-0">
                        {{ $title }}
                        {{-- SE il tiolo è troppo grande, va a capo, ingrandendo al card, ma arrivando ad occupare al massimo 2 righe --}}
                    </h2>

                    {{ $people ?? '' }}

                </div>

                {{ $badge ?? '' }}

            </div>

            {{ $details ?? '' }}

            @if($formattedDescription)
                <p class="mt-3 max-w-full wrap-break-word line-clamp-2 min-w-0 text-sm leading-5 text-gray-400">
                    {{ $formattedDescription }}
                </p>
            @endif

            <div class="pointer-events-auto relative z-30 mt-4 flex flex-wrap items-center gap-2 border-t border-white/10 pt-3">

                {{ $actions ?? '' }}

                <span class="pointer-events-none ml-0 text-xs font-semibold text-blue-400 sm:ml-auto">
                    Visualizza dettagli →
                </span>

            </div>

        </div>

    </div>

</article>