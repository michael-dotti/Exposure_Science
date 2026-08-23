<x-layout-public :fullWidth="true">

    <x-slot:title>
        Home
    </x-slot:title>

    <x-slot:heading>
    </x-slot:heading>

    <section class="relative flex min-h-[75vh] items-center overflow-hidden text-white">
        <div class="absolute inset-0">

            <img
                src="{{ asset('images/homePage.webp') }}"
                alt="Gruppo di ricerca"
                class="h-full w-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

        </div>
        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 md:px-10">
            <div class="max-w-3xl">
                <span class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-400">
                    Gruppo di ricerca
                </span>
                <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-white md:text-6xl">

                    Ricerca, innovazione
                    <span class="text-blue-400">
                        e conoscenza
                    </span>

                </h1>
                <p class="mt-5 max-w-xl text-lg leading-7 text-gray-300 md:text-xl">
                    Un luogo in cui idee, ricerca e collaborazione
                    si incontrano per creare nuova conoscenza.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">

                    <a
                        href="#chi-siamo"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500"
                    >
                        Scopri il nostro gruppo
                    </a>

                    <a
                        href="#contatti"
                        class="inline-flex items-center rounded-lg border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10"
                    >
                        Contattaci →
                    </a>

                </div>
            </div>
        </div>
    </section>
    <section
        id="chi-siamo"
        class="bg-slate-900 px-6 py-20 text-white"
    >
        <div class="mx-auto max-w-5xl text-center">
            <span class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                Il nostro gruppo
            </span>
            <h2 class="mt-3 text-3xl font-bold md:text-4xl">
                Chi siamo
            </h2>
            <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-gray-300 md:text-lg">
                Siamo un gruppo di ricerca universitario impegnato nello studio,
                nello sviluppo e nella condivisione di nuove conoscenze.
                Le nostre attività combinano ricerca, collaborazione e innovazione,
                con l'obiettivo di contribuire alla crescita scientifica e tecnologica.
            </p>
            <a
                href="{{ route('public.users.index') }}"
                class="mt-8 inline-flex items-center rounded-lg border border-blue-500/40 bg-blue-500/10 px-5 py-3 text-sm font-semibold text-blue-300 transition hover:bg-blue-500/20 hover:text-white"
            >
                Scopri il nostro team →
            </a>
        </div>
    </section>
    @if($news && $news->count())

        <section class="bg-slate-950 px-6 py-20 text-white">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 text-center">
                    <span class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        Aggiornamenti
                    </span>

                    <h2 class="mt-3 text-3xl font-bold md:text-4xl">
                        Ultime novità
                    </h2>

                    <p class="mx-auto mt-3 max-w-2xl text-gray-400">
                        Scopri le ultime attività e novità del nostro gruppo di ricerca.
                    </p>

                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($news as $n)

                        <a
                            href="{{ route('public.news.show', $n) }}"
                            class="group overflow-hidden rounded-xl border border-white/10 bg-slate-800/50 transition duration-300 hover:-translate-y-1 hover:border-blue-400/40 hover:bg-slate-800"
                        >
                            <div class="h-48 overflow-hidden">
                                @if($n->imagePath)

                                    <img
                                        src="{{ Storage::url($n->imagePath) }}"
                                        alt="{{ $n->title }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center bg-slate-800">
                                        <i class="fa-regular fa-newspaper text-4xl text-gray-500"></i>
                                    </div>

                                @endif

                            </div>
                            <div class="p-5">
                                <span class="text-xs font-semibold text-orange-400">
                                    {{ $n->publicationDate }}
                                </span>
                                <h3 class="mt-2 text-lg font-bold text-white transition group-hover:text-blue-300">
                                    {{ $n->title }}
                                </h3>
                                <p class="mt-3 text-sm leading-6 text-gray-400">
                                    {{ Str::limit(
                                        strip_tags($n->content),
                                        120
                                    ) }}
                                </p>
                                <div class="mt-5 text-sm font-semibold text-blue-400">
                                    Leggi la novità →
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a
                        href="{{ route('public.news.index') }}"
                        class="inline-flex items-center rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white"
                    >
                        Visualizza tutte le novità →
                    </a>
                </div>
            </div>
        </section>
    @endif

    <section
        id="contatti"
        class="border-t border-white/10 bg-slate-900 px-6 py-14 text-white"
    >
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-10 md:grid-cols-2">
                <div>

                    <span class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        Contatti
                    </span>

                    <h2 class="mt-3 text-2xl font-bold">
                        Entra in contatto con noi
                    </h2>

                    <p class="mt-4 max-w-lg leading-7 text-gray-400">
                        Per informazioni sulle nostre attività,
                        sui progetti e sulle collaborazioni puoi
                        contattare il nostro gruppo di ricerca.
                    </p>

                </div>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">
                                Indirizzo
                            </p>
                            <p class="mt-1 text-sm text-gray-400">
                                Via Roma, 123
                            </p>
                            <p class="text-sm text-gray-400">
                                00100 Roma (RM)
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">
                                Email
                            </p>
                            <a
                                href="mailto:info@esempio.it"
                                class="mt-1 block text-sm text-gray-400 transition hover:text-blue-400"
                            >
                                info@esempio.it
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout-public>