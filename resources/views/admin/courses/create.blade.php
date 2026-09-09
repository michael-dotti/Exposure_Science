<x-layout-private>
    <x-slot:title>
        Nuovo Corso
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <x-form-layout
            action="{{ route('admin.courses.store') }}"
            method="POST"
        >
            <x-slot:header>
                <h2 class="text-lg font-semibold text-white">
                    Dati del corso
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Inserisci le informazioni necessarie per creare il corso
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
                        <x-label
                            name="language"
                            :required="true"
                        >
                            Lingua
                        </x-label>

                        <select
                            id="language"
                            name="language"
                            required
                            class="block w-full rounded-md border-0
                                bg-white/5 px-3 py-2 text-white
                                shadow-sm ring-1 ring-inset ring-white/10
                                focus:ring-2 focus:ring-inset
                                focus:ring-indigo-500 sm:text-sm"
                        >
                            <option
                                value=""
                                class="bg-gray-800 text-gray-400"
                                @selected(old('language') === null)
                            >
                                Seleziona una lingua
                            </option>

                            @foreach ($languages as $language)
                                <option
                                    value="{{ $language->value }}"
                                    class="bg-gray-800 text-white"
                                    @selected(old('language') === $language->value)
                                >
                                    {{ ucfirst($language->value) }}
                                </option>
                            @endforeach
                        </select>

                        <x-form-error name="language" />
                    </div>

                    <div class="grid gap-5 md:grid-cols-3">

                        <div>
                            <x-label name="points" :required="true">
                                Crediti
                            </x-label>

                            <input
                                id="points"
                                name="points"
                                type="number"
                                min="1"
                                max="16"
                                value="{{ old('points') }}"
                                required
                                class="block w-full rounded-md border-0 bg-white/5 px-3 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm"
                            >

                            <x-form-error name="points" />
                        </div>

                        <div>
                            <x-label name="semester" :required="true">
                                Semestre
                            </x-label>

                            <input
                                id="semester"
                                name="semester"
                                type="number"
                                min="1"
                                max="2"
                                value="{{ old('semester') }}"
                                required
                                class="block w-full rounded-md border-0 bg-white/5 px-3 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm"
                            >

                            <x-form-error name="semester" />
                        </div>

                        <div>
                            <x-label name="duration" :required="true">
                                Durata in ore
                            </x-label>

                            <input
                                id="duration"
                                name="duration"
                                type="number"
                                min="1"
                                max="1000"
                                value="{{ old('duration') }}"
                                required
                                class="block w-full rounded-md border-0 bg-white/5 px-3 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm"
                            >

                            <x-form-error name="duration" />
                        </div>

                    </div>

                </div>
            </x-content-section>

            <x-content-section
            >
                <x-label name="description" description="Inserisci il contenuto e gli obiettivi del corso" :required="true" > 
                    Descrizione
                </x-label>

                <x-textarea-quill
                    name="description"
                    :required="true"
                    value="{!! old('description') !!}"
                />

                

            </x-content-section>

            <x-content-section
            >
                <x-label name="teachers[]" description="Seleziona uno o più docenti da associare al corso" :required="true" > 
                    Docenti
                </x-label>

                <div class="grid grid-flow-col grid-rows-4 gap-x-10 gap-y-3 overflow-x-auto rounded-lg border border-white/10 bg-white/5 p-4">

                    @foreach ($teachers as $teacher)

                        <div class="flex items-center gap-x-3 pr-4">

                            <input
                                id="teacher-{{ $teacher->id }}"
                                name="teachers[]"
                                value="{{ $teacher->id }}"
                                type="checkbox"
                                @checked(
                                    in_array(
                                        $teacher->id,
                                        old('teachers', $defaultTeachers)
                                    )
                                )
                                class="h-4 w-4 rounded border-white/10 bg-transparent text-indigo-600 focus:ring-indigo-600"
                            >

                            <label
                                for="teacher-{{ $teacher->id }}"
                                class="whitespace-nowrap text-sm text-white"
                            >
                                {{ $teacher->name }}
                                {{ $teacher->surname }}
                            </label>

                        </div>

                    @endforeach

                </div>

                <x-form-error name="teachers[]" />

            </x-content-section>

            <x-slot:buttons>
                <x-save-button type="submit">
                    Salva
                </x-save-button>
                
                <a href="{{ route('admin.courses.index') }}">
                    <x-danger-button type="button">
                        Annulla
                    </x-danger-button>
                </a>
            </x-slot:buttons>

        </x-form-layout>

    </div>
</x-layout-private>