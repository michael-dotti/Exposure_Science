@props([
    'title',
    'description',
    'resetUrl' => null,
    'activeFilters' => [],
    'variant' => 'private',
])

@php
    $backgroundClass = match ($variant) {
        'public'  => 'bg-slate-900',
        'private' => 'bg-slate-800',
        default   => 'bg-slate-800',
    };
@endphp

<div
    {{ $attributes->class([
        'relative z-30 mb-6 overflow-visible rounded-xl',
        'border border-white/10',
        $backgroundClass,
        'px-4 py-4 shadow-md',
    ]) }}
>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

        {{-- Intestazione --}}
        <div class="flex min-w-0 items-start gap-3 lg:pt-1">

            {{-- Icona imbuto --}}
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-amber-400/20 bg-amber-400/10 text-sm text-amber-300">
                <i
                    class="fa-solid fa-filter"
                    aria-hidden="true"
                ></i>
            </div>

            <div class="min-w-0">
                <h2 class="text-sm font-semibold text-white">
                    {{ $title }}
                </h2>

                <p class="mt-0.5 text-xs leading-5 text-gray-400">
                    {{ $description }}
                </p>
            </div>

        </div>

        {{-- Parte destra --}}
        <div class="relative z-30 flex flex-col gap-2 lg:items-end">

            {{-- Select e pulsante rimozione --}}
            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">

                {{ $slot }}

                @if (count($activeFilters) > 0 && $resetUrl)
                <a
                    href="{{ $resetUrl }}"
                    title="Rimuovi tutti i filtri"
                    class="inline-flex h-7 shrink-0 items-center justify-center gap-1
                        rounded-full border border-red-400/20
                        bg-red-500/10 px-2.5
                        text-[11px] font-semibold leading-none text-red-300
                        transition
                        hover:border-red-400/40
                        hover:bg-red-500/20
                        hover:text-red-200"
                >
                    <i
                        class="fa-solid fa-xmark text-[9px]"
                        aria-hidden="true"
                    ></i>

                    Rimuovi
                </a>
            @endif

            </div>

            {{-- Filtri applicati sotto le select --}}
            @if (count($activeFilters) > 0)
                <div class="flex flex-wrap items-center gap-1.5 sm:justify-end">

                    <span class="mr-1 text-2xs font-semibold uppercase tracking-wider text-gray-500">
                        Filtri:
                    </span>

                    @foreach ($activeFilters as $filter)
                        <span class="inline-flex items-center gap-1 rounded-full border border-green-400/20 bg-green-500/10 px-2.5 py-1 text-[11px] font-semibold text-green-300">
                            <i
                                class="fa-solid fa-check text-[9px]"
                                aria-hidden="true"
                            ></i>

                            <span class="text-green-200">
                                {{ $filter['label'] }}:
                            </span>

                            <span class="text-green-100">
                                {{ $filter['value'] }}
                            </span>
                        </span>
                    @endforeach

                </div>
            @endif

        </div>

    </div>
</div>