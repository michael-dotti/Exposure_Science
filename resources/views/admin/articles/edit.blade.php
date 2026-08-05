<x-layout-menu-bar-private>
    <x-slot:title>
        Modifica Articolo
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <div class="mb-6 mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Dati dell'articolo
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Aggiorna le informazioni di {{ $article->title }}
                </p>
            </div>

            <x-link-button href="/admin/articles">
                Indietro
            </x-link-button>
        </div>

        <form
            method="POST"
            action="/admin/articles/{{ $article->id }}"
            id="delete-form"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>

        <x-form-layout
            action="/admin/articles/{{ $article->id }}"
            method="PATCH"
            :hasFiles="true"
        >
            {{-- Intestazione --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="flex items-center gap-4 p-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                        📄
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="truncate text-base font-semibold text-white">
                            {{ $article->title }}
                        </h2>

                        <div class="mt-1 space-y-1">
                            <p class="text-xs text-gray-400">
                                I campi contrassegnati con
                                <span class="text-red-500">*</span>
                                sono obbligatori
                            </p>

                            <p class="text-xs text-gray-400">
                                Devi indicare un link oppure caricare un documento
                            </p>
                        </div>
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
                            value="{{ old('title', $article->title) }}"
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
                            value="{!! old('abstract', $article->abstract) !!}"
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
                        Seleziona gli autori da associare all'articolo
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
                                            old(
                                                'users',
                                                $article->users
                                                    ->pluck('id')
                                                    ->toArray()
                                            )
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
                        Seleziona le aree di ricerca associate all'articolo
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
                                            old(
                                                'areas',
                                                $article->researchAreas
                                                    ->pluck('id')
                                                    ->toArray()
                                            )
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
                                value="{{ old('external_url', $article->external_url) }}"
                            />

                            <x-form-error name="external_url" />
                        </div>

                        <div>
                            <x-input-file
                                name="file_path"
                                label="Documento"
                                :currentFile="$article->file_path
                                    ? basename($article->file_path)
                                    : null"
                            />

                            <input
                                type="hidden"
                                name="remove_file"
                                value="0"
                            >

                            <x-form-error name="file_path" />
                            <x-form-error name="remove_file" />
                        </div>
                    </div>

                    <x-form-error name="link_or_document" />
                </div>
            </div>

            {{-- Immagine --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="image_path">
                        {{ $article->image_path
                            ? 'Immagine corrente'
                            : 'Seleziona immagine' }}
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Puoi mantenere l'immagine attuale oppure selezionarne una nuova
                    </p>

                    <x-image-preview-articles
                        name="image_path"
                        :currentImage="$article->image_path
                            ? Storage::url($article->image_path)
                            : null"
                    />

                    <x-form-error name="image_path" />
                </div>
            </div>

            <x-slot:buttons>
                <x-danger-button
                    type="submit"
                    form="delete-form"
                >
                    Elimina
                </x-danger-button>

                <x-save-button type="submit">
                    Salva
                </x-save-button>
            </x-slot:buttons>
        </x-form-layout>
    </div>
</x-layout-menu-bar-private>