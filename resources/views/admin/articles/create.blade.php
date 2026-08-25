<x-layout-private>
    <x-slot:title>
        Nuovo Articolo
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <x-form-layout
            action="{{ route('admin.articles.store') }}"
            method="POST"
            :hasFiles="true"
        >
            <x-slot:header>
                <h2 class="text-lg font-semibold text-white">
                    Dati dell'articolo
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Inserisci le informazioni necessarie per creare l'articolo
                </p>
            </x-slot:header>
            <x-content-section>

                <div class="space-y-5">

                    <x-input-text
                        :required="true"
                        label="Titolo"
                        name="title"
                        value="{{ old('title') }}"
                    />

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

                    </div>

                </div>

            </x-content-section>

            <x-content-section>
                <x-label name="users[]" :required="true" description="Seleziona uno o più autori da associare all'articolo" > 
                        Autori
                </x-label>

                <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">

                    @foreach ($users as $user)

                        <div class="flex items-center gap-x-3 pr-4">

                            <input
                                id="user-{{ $user->id }}"
                                name="users[]"
                                value="{{ $user->id }}"
                                type="checkbox"
                                @if ($user->id == auth()->id())
                                    onclick="return false;"
                                @endif
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

                <x-form-error name="users[]" />

            </x-content-section>

            <x-content-section>
                <x-label name="areas[]" :required="true" description="Seleziona una o più aree di ricerca da associare all'articolo" > 
                        Aree di ricerca
                </x-label>
                
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

                <x-form-error name="areas[]" />

            </x-content-section>

            <x-content-section
                title="Documento o link"
                description="Inserisci un URL esterno oppure carica il documento dell'articolo"
                :required="true"
            >

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

                <p class="mt-3 text-xs text-gray-400">
                    Devi fornire uno dei due.
                </p>

            </x-content-section>

            <x-content-section>
                <x-label name="image_path" description="Seleziona un'immagine di copertina per l'articolo" > 
                        Immagine
                </x-label>

                <x-image-preview-articles
                    name="image_path"
                />

                <x-form-error name="image_path" />

            </x-content-section>

            <x-slot:buttons>
                <x-save-button type="submit">
                    Salva
                </x-save-button>

                <a href="{{ route('admin.articles.index') }}">
                    <x-danger-button type="button">
                        Annulla
                    </x-danger-button>
                </a>
            </x-slot:buttons>

        </x-form-layout>

    </div>
</x-layout-private>