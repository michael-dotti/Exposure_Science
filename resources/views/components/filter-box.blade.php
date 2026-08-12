@props([
    'title',
    'description',
])

<div class="mb-4 rounded-lg border border-white/10 bg-white/[0.03] px-4 py-3">

    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">

        <div>
            <h2 class="text-sm font-semibold text-white">
                {{ $title }}
            </h2>

            <p class="mt-1 text-xs text-gray-400">
                {{ $description }}
            </p>
        </div>

        <div class="flex flex-col gap-2">

            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                {{ $slot }}
            </div>

            @isset($activeFilters)
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400">
                        Filtri applicati:
                    </span>

                    {{ $activeFilters }}
                </div>
            @endisset

        </div>

    </div>

</div>