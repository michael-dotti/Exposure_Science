@props([
    'title',
    'description' => null,
])

<div class="relative mt-6 w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">

    <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

    <div class="p-5">

        <h2 class="text-base font-semibold text-white">
            {{ $title }}
        </h2>

        @if ($description)
            <p class="mb-4 mt-1 text-xs text-gray-400">
                {{ $description }}
            </p>
        @else
            <div class="mb-4"></div>
        @endif

        {{ $slot }}

    </div>

</div>