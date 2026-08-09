<x-layout-private>
    <x-slot:title>
        Nuovo Corso
    </x-slot:title>

    <div class="mx-auto w-full max-w-4xl">
        <div class="mb-6 mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Dati del nuovo corso
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Inserisci le informazioni necessarie per creare il corso
                </p>
            </div>

            <x-link-button href="/admin/courses">
                Indietro
            </x-link-button>
        </div>

        <x-form-layout
            action="/admin/courses"
            method="POST"
        >
            {{-- Intestazione del form --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="flex items-center gap-4 p-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-blue-400/20 bg-blue-500/5 text-3xl leading-none">
                        <i class="fa-regular fa-file"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-white">
                            Informazioni del corso
                        </h2>

                        <p class="mt-1 text-xs text-gray-400">
                            I campi contrassegnati con
                            <span class="text-red-500">*</span>
                            sono obbligatori
                        </p>
                    </div>
                </div>
            </div>

            {{-- Dati principali --}}
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

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <x-input-text
                                :required="true"
                                label="Lingua"
                                name="language"
                                value="{{ old('language') }}"
                            />
                        </div>

                        <div>
                            <x-input-text
                                :required="true"
                                label="Codice"
                                name="code"
                                value="{{ old('code') }}"
                            />

                            <p class="mt-1 text-xs text-gray-400">
                                Massimo 10 caratteri
                            </p>
                        </div>
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
            </div>

            {{-- Descrizione --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="description" :required="true">
                        Descrizione
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Descrivi il contenuto e gli obiettivi del corso
                    </p>

                    <x-textarea-quill
                        name="description"
                        :required="true"
                        value="{!! old('description') !!}"
                    />

                    <x-form-error name="description" />
                </div>
            </div>

            {{-- Docenti --}}
            <div class="relative w-full overflow-hidden rounded-lg border border-white/10 bg-slate-800/50">
                <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>

                <div class="p-5">
                    <x-label name="teachers" :required="true">
                        Docenti associati al corso (minimo 1)
                    </x-label>

                    <p class="mb-3 mt-1 text-xs text-gray-400">
                        Seleziona uno o più docenti da associare al corso
                    </p>

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
                                            old('teachers', [auth()->id()])
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

                    <x-form-error name="teachers" />
                    <x-form-error name="teachers.*" />
                </div>
            </div>

            <x-slot:buttons>
                <a href="/admin/courses">
                    <x-danger-button type="button">
                        Annulla
                    </x-danger-button>
                </a>

                <x-save-button type="submit">
                    Salva
                </x-save-button>
            </x-slot:buttons>
        </x-form-layout>
    </div>
</x-layout-menu-bar-private>