@props([
    'pageTitle',
    'heading',
    'backHref',
    'title',
    'subtitle' => null,
])

<x-layout-private>
    <x-slot:title>
        {{ $pageTitle }}
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">

        <div class="mb-6 mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    {{ $heading }}
                </h2>

                @if ($subtitle)
                    <p class="mt-1 text-sm text-gray-400">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            <x-private-button-back :href="$backHref"/>
        </div>

        <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

            <div class="flex items-center gap-4 p-4">

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                    {{ $icon }}
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-white wrap-break-word text-2xl font-bold">
                        {{ $title }}
                    </h2>

                    @isset($headerInfo)
                        <div class="mt-2">
                            {{ $headerInfo }}
                        </div>
                    @endisset
                </div>

            </div>
        </div>

        {{ $slot }}

        @isset($actions)
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-white/10 py-5">
                {{ $actions }}
            </div>
        @endisset

    </div>
</x-layout-private>