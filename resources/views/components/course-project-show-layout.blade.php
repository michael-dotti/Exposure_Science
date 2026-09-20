@props([
    'title',
    'backTitle',
    'backHref',
])

<x-layout-public>

    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">
            <h1 class="wrap-break-word text-3xl font-bold leading-tight text-amber-300">
                {{ $title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante indietro --}}
        <div class="mb-8">
            <x-public-button-back
                :title="$backTitle"
                :href="$backHref"
            />
        </div>

        {{-- Scheda principale --}}
        <article class="overflow-hidden rounded-2xl border border-white/10 bg-gray-800 shadow-2xl">
            {{ $slot }}
        </article>

    </main>

</x-layout-public>