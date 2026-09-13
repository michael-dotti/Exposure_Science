<x-layout-public>

    <x-slot:title>
        {{ $n->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-5xl px-4 py-8 text-center sm:px-6 lg:px-8">
            <h1 class="wrap-break-word text-5xl font-bold leading-tight text-amber-300">
                {{ $n->title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl p-4 sm:px-6 lg:px-8">

        {{-- Unico pulsante indietro --}}
        <div class="mb-7">
            <x-public-botton-back
                title="Torna alle novità"
                :href="route('public.news.index')"
            />
        </div>

        <article>

            {{-- Immagine principale --}}
            <div
                class="relative overflow-hidden rounded-2xl
                       border border-white/10 bg-gray-900
                       shadow-2xl"
            >
                @if ($n->image_path)

                    <img
                        src="{{ Storage::url($n->image_path) }}"
                        alt="Immagine della notizia {{ $n->title }}"
                        class="h-auto max-h-162.5 w-full object-cover object-center"
                    >

                @else

                    <div
                        class="flex min-h-100 w-full flex-col
                               items-center justify-center text-gray-500"
                    >
                        <span
                            class="flex h-20 w-20 items-center
                                   justify-center rounded-2xl
                                   bg-white/5 text-4xl"
                        >
                            <i
                                class="fa-regular fa-newspaper"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <p class="mt-4 text-sm font-medium">
                            Immagine non disponibile
                        </p>
                    </div>

                @endif
            </div>

            {{-- Data di pubblicazione --}}
            <div class="mb-7 flex items-center gap-2 text-md text-gray-400 mt-10">
                <i
                    class="fa-regular fa-calendar text-cyan-400"
                    aria-hidden="true"
                ></i>
                <span>
                    Pubblicata il
                </span>

                <time
                    datetime="{{ $n->created_at->format('Y-m-d') }}"
                    class="font-semibold text-gray-200"
                >
                    {{ $n->created_at->format('d/m/Y') }}
                </time>
            </div>

            {{-- contenuto --}}
            <section class="mx-auto max-w-4xl py-4 md:py-4">
            
                {{-- Testo della notizia --}}
                @if (filled(strip_tags($n->content ?? '')))

                    <div class="news-content wrap-anywhere">
                        {!! $n->content !!}
                    </div>

                @else

                    <p class="text-base italic text-gray-400">
                        Il contenuto della notizia non è disponibile.
                    </p>

                @endif

            </section>

        </article>

    </main>

    <style>
        .news-content {
            width: 100%;
            max-width: 100%;
            color: rgb(209 213 219);
            font-size: 1.0625rem;
            line-height: 1.9;
            overflow-wrap: anywhere;
            word-break: normal;
            white-space: normal;
        }

        .news-content * {
            max-width: 100%;
        }

        .news-content p {
            margin: 0 0 1.25rem;
            padding: 0;
            color: rgb(209 213 219) !important;
            line-height: 1.9;
        }

        .news-content p:last-child {
            margin-bottom: 0;
        }

        .news-content h1 {
            margin: 2rem 0 1rem;
            color: rgb(255 255 255) !important;
            font-size: 1.875rem;
            font-weight: 800;
            line-height: 1.3;
        }

        .news-content h2 {
            margin: 1.75rem 0 0.875rem;
            color: rgb(255 255 255) !important;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .news-content h3 {
            margin: 1.5rem 0 0.75rem;
            color: rgb(255 255 255) !important;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .news-content strong,
        .news-content b {
            color: rgb(255 255 255) !important;
            font-weight: 700;
        }

        .news-content em,
        .news-content i {
            font-style: italic;
        }

        .news-content ul {
            margin: 1.25rem 0;
            padding-left: 1.75rem;
            color: rgb(209 213 219);
            list-style-type: disc;
        }

        .news-content ol {
            margin: 1.25rem 0;
            padding-left: 1.75rem;
            color: rgb(209 213 219);
            list-style-type: decimal;
        }

        .news-content li {
            margin-bottom: 0.5rem;
            color: rgb(209 213 219) !important;
        }

        .news-content blockquote {
            margin: 1.5rem 0;
            padding: 1rem 1.25rem;
            border-left: 4px solid rgb(251 191 36);
            border-radius: 0 0.5rem 0.5rem 0;
            background-color: rgba(255, 255, 255, 0.03);
            color: rgb(229 231 235) !important;
            font-style: italic;
        }

        .news-content a {
            color: rgb(34 211 238) !important;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .news-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 1.5rem auto;
            border-radius: 0.75rem;
        }

        .news-content pre {
            max-width: 100%;
            margin: 1.5rem 0;
            padding: 1rem;
            overflow-x: auto;
            border-radius: 0.75rem;
            background-color: rgb(17 24 39);
            color: rgb(229 231 235) !important;
            white-space: pre-wrap;
        }
    </style>

</x-layout-public>