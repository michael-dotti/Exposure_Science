<x-layout-private>
    <x-slot:title>
        Nuovo Articolo
    </x-slot:title>

    <div class="flex justify-end">
        <x-link-button href="{{ route('admin.articles.index') }}" >Indietro</x-link-button>
    </div>
    

    <x-form-layout action="{{ route('admin.articles.store') }}" method="POST" :hasFiles="true">
        <x-slot:header>
            <h1 class="text-base/7 font-semibold text-white">Crea un nuovo Articolo</h2>
            <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
            <p class="text-xs text-gray-400 mt-1">2. Devi fornire un link per acquistare l'articolo o caricare il documento</p>
        </x-slot:header>
            {{-- Intestazione --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="flex items-center gap-4 p-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                        📄
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-white">
                            Informazioni dell'articolo
                        </h2>

                        <p class="mt-1 text-xs text-gray-400">
                            I campi contrassegnati con
                            <span class="text-red-500">*</span>
                            sono obbligatori
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Devi indicare un link oppure caricare un documento
                        </p>
                    </div>
                </div>
            </div>

            {{-- Titolo e abstract --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="space-y-5 p-5">
                    <div>
                        <x-input-text
                            :required="true"
                            label="Titolo"
                            name="title"
                            value="{{ old('title') }}"
                        />
                    </div>

                    <div>
                        <x-label name="abstract" :required="true">
                            Abstract
                        </x-label>

                        <p class="mb-3 mt-1 text-xs text-gray-400">
                            Descrivi brevemente il contenuto dell'articolo
                        </p>

                        <x-textarea-quill
                            name="abstract"
                            :required="true"
                            value="{!! old('abstract') !!}"
                        />

                        <x-form-error name="abstract" />
                    </div>
                </div>
            </div>

            {{-- Autori --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="users" :required="true">
                        Autori dell'articolo (minimo 1)
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Seleziona uno o più autori da associare all'articolo
                    </p>

                    <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                        @foreach ($users as $user)
                            <div class="flex items-center gap-x-3 pr-4">
                                <input
                                    id="user-{{ $user->id }}"
                                    name="users[]"
                                    value="{{ $user->id }}"
                                    type="checkbox"
                                    @checked(
                                        in_array(
                                            $user->id,
                                            old('users', [auth()->id()])
                                        )
                                    )
                                    class="h-4 w-4 rounded border-white/10 bg-transparent text-indigo-600 focus:ring-indigo-600"
                                >

                                <label
                                    for="user-{{ $user->id }}"
                                    class="whitespace-nowrap text-sm text-white"
                                >
                                    {{ $user->name }}
                                    {{ $user->surname }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <x-form-error name="users" />
                    <x-form-error name="users.*" />
                </div>
            </div>

            {{-- Aree di ricerca --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="areas" :required="true">
                        Aree di ricerca dell'articolo (minimo 1)
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Seleziona una o più aree di ricerca
                    </p>

                    <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">
                        @foreach ($areas as $area)
                            <div class="flex items-center gap-x-3 pr-4">
                                <input
                                    id="area-{{ $area->id }}"
                                    name="areas[]"
                                    value="{{ $area->id }}"
                                    type="checkbox"
                                    @checked(
                                        in_array(
                                            $area->id,
                                            old('areas', [])
                                        )
                                    )
                                    class="h-4 w-4 rounded border-white/10 bg-transparent text-indigo-600 focus:ring-indigo-600"
                                >

                                <label
                                    for="area-{{ $area->id }}"
                                    class="whitespace-nowrap text-sm text-white"
                                >
                                    {{ $area->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <x-form-error name="areas" />
                    <x-form-error name="areas.*" />
                </div>
            </div>

            {{-- Link o documento --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="link_or_document" :required="true">
                        Link o documento
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Inserisci un URL oppure carica il documento dell'articolo
                    </p>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <x-input-text
                                name="external_url"
                                label="URL esterno"
                                value="{{ old('external_url') }}"
                            />

                            <x-form-error name="external_url" />
                        </div>

                        <div>
                            <x-input-file
                                name="file_path"
                                label="Documento"
                            />

                            <x-form-error name="file_path" />
                        </div>
                    </div>

                    <x-form-error name="link_or_document" />
                </div>
            </div>

            {{-- Immagine --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="image_path" :required="true">
                        Immagine
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Seleziona un'immagine di copertina per l'articolo
                    </p>

                    <x-image-preview-articles
                        name="image_path"
                        :required="true"
                    />

                    <x-form-error name="image_path" />
                </div>
            </div>

            <x-slot:buttons>
                <x-save-button type="submit" >Save</x-save-button>
                <a href="{{ route('admin.articles.index') }}">
                    <x-danger-button type="button">Cancel</x-danger-button>
                </a>
            </x-slot:buttons>
    </x-form-layout>
</x-layout-private>

