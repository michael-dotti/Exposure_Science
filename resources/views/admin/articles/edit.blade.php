<x-layout-private>
    <x-slot:title>
        Modifica Articolo
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <form
            method="POST"
            action="{{ route('admin.articles.destroy', $article) }}"
            id="delete_form"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>

        <x-form-layout
            action="{{ route('admin.articles.update', $article) }}"
            method="PATCH"
            :hasFiles="true"
        >
            <x-slot:header>
                <h2 class="text-lg font-semibold text-white">
                    Dati dell'articolo
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Aggiorna le informazioni dell'articolo
                </p>
            </x-slot:header>
            <x-content-section>

                <div class="space-y-5">

                    <x-input-text
                        :required="true"
                        label="Titolo"
                        name="title"
                        value="{{ old('title', $article->title) }}"
                    />

                    <div>
                        <x-label name="abstract" :required="true">
                            Abstract
                        </x-label>

                        <p class="mb-3 mt-1 text-xs text-gray-400">
                            Modifica il contenuto dell'abstract
                        </p>

                        <x-textarea-quill
                            name="abstract"
                            :required="true"
                            value="{!! old('abstract', $article->abstract) !!}"
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
                            value="{{ old('external_url', $article->external_url) }}"
                        />

                        <x-form-error name="external_url" />
                    </div>

                    <div>
                        <x-input-file
                            name="file_path"
                            label="Documento"
                            currentFile="{{ $article->document ? $article->document->file_name : null }}"
                        />

                        <input
                            type="hidden"
                            name="remove_file"
                            value="0"
                        >

                        <x-form-error name="file_path" />
                    </div>

                </div>

                <x-form-error name="link_or_document" />

            </x-content-section>

            <x-content-section>
                <x-label name="image_path"> 
                            {{ $article->image_path
                            ? 'Immagine corrente'
                            : 'Seleziona immagine' }}
                </x-label>

                <x-image-preview-articles
                    name="image_path"
                    :currentImage="$article->image_path
                        ? Storage::url($article->image_path)
                        : null"
                />

                <x-form-error name="image_path" />

            </x-content-section>

            <x-slot:buttons>

                <x-danger-button
                    type="submit"
                    form="delete_form"
                >
                    Elimina
                </x-danger-button>

                <x-save-button type="submit">
                    Salva modifiche
                </x-save-button>

            </x-slot:buttons>

        </x-form-layout>

    </div>
</x-layout-private>