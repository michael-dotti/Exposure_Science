@props([
    'title',
    'backTitle',
    'backHref',
])

@once
    @push('styles')
        <style>
            .course-project-content,
            .course-project-content p {
                max-width: 100%;
                overflow-wrap: anywhere;
                white-space: normal;
            }

            .course-project-content p {
                margin-bottom: 1rem;
            }

            .course-project-content p:last-child {
                margin-bottom: 0;
            }

            .course-project-content ul {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: disc;
            }

            .course-project-content ol {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: decimal;
            }

            .course-project-content li {
                margin-bottom: 0.25rem;
            }

            .course-project-content a {
                color: rgb(34 211 238);
                text-decoration: underline;
                text-underline-offset: 3px;
            }

            .course-project-content img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
            }
        </style>
    @endpush
@endonce

<x-layout-public>

    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center sm:px-6 lg:px-8">
            <h1 class="break-words text-3xl font-bold leading-tight text-amber-300">
                {{ $title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Pulsante indietro --}}
        <div class="mb-8">
            <x-public-botton-back
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