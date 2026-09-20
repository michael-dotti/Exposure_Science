<x-layout-public>

    <x-slot:title>
        {{ $news->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="mx-auto w-full max-w-5xl px-4 py-8 text-center sm:px-6 lg:px-8">
            <h1 class="wrap-break-word text-5xl font-bold leading-tight text-amber-300">
                {{ $news->title }}
            </h1>
        </div>
    </x-slot:heading>

    <main class="mx-auto w-full max-w-6xl p-4 sm:px-6 lg:px-8">

        {{-- Unico pulsante indietro --}}
        <div class="mb-7">
            <x-public-button-back
                title="Torna alle novità"
                :href="route('admin.news-management.index')"
            />
        </div>

        <article>

            {{-- Immagine principale --}}
            <div
                class="relative overflow-hidden rounded-2xl
                       border border-white/10 bg-gray-900
                       shadow-2xl"
            >
                @if ($news->image_path)

                    <img
                        src="{{ Storage::url($news->image_path) }}"
                        alt="Immagine della notizia {{ $news->title }}"
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
                    datetime="{{ $news->created_at->format('Y-m-d') }}"
                    class="font-semibold text-gray-200"
                >
                    {{ $news->created_at->format('d/m/Y') }}
                </time>
            </div>

            {{-- contenuto --}}
            <section class="mx-auto max-w-4xl py-4 md:py-4">
            
                {{-- Testo della notizia --}}
                @if (filled(strip_tags($news->content ?? '')))

                    <div class="news-content wrap-anywhere">
                        {!! $news->content !!}
                    </div>

                @else

                    <p class="text-base italic text-gray-400">
                        Il contenuto della notizia non è disponibile.
                    </p>

                @endif

            </section>

        </article>

  </main>
</x-layout-public>