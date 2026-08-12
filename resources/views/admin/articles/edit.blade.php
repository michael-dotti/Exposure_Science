<x-layout-private>
    <x-slot:title>
        Modifica Articolo
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="{{ route('admin.articles.index') }}" >Indietro</x-link-button>
    </div>
             
    <form method="POST" action="{{ route('admin.articles.destroy',$article->id) }}" id="delete_form" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    
    <x-form-layout action="{{ route('admin.articles.update',$article->id) }}" method="patch" :hasFiles="true">
      <x-slot:header>
        <h1 class="text-base/7 font-semibold text-white">Modifica Articolo: {{ $article->title }}</h2>
        <div class="mt-1 mb-8">
          <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
          <p class="text-xs text-gray-400 mt-1">2. Devi fornire un link per acquistare l'articolo o caricare il documento</p>
        </div>
      </x-slot:header>

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
                                    @if($user->id == auth()->user()->id)
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

        <div>
          <x-label name="link_or_document" :required="True">Scegli tra un documento o un link</x-label>
            <div class="grid md:grid-cols-2 md:gap-6">
            <div>
              <x-input-text name="external_url" label="URL" :value="$article->external_url"/>
            </div>
            <div>
              <x-input-file name="file_path" label="Documento" currentFile="{{ $article->document ? $article->document->file_name : null }}"/>
              <input type="hidden" name="remove_file" value="0"/> 
            </div>
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
        <x-save-button type="submit" >Salva</x-save-button>
        <x-danger-button form="delete_form" >Elimina</x-danger-button>
      </x-slot:buttons>
    </x-form-layout>

</x-layout-private>