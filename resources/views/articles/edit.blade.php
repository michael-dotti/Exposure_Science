<x-layout-menu-bar-private>
    <x-slot:title>
        Modifica Articolo
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/articles" >Indietro</x-link-button>
    </div>
             
    <form method="POST" action="/articles/{{ $article->id }}" id="delete_form" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    <form method="POST" action="/articles/{{ $article->id }}" enctype="multipart/form-data">
      @csrf
       @method('PATCH')
          <div class="space-y-12 text-white">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Modifica Articolo: {{ $article->title }}</h2>
              <div class="mt-1 mb-8">
                <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
                <p class="text-xs text-gray-400 mt-1">2. Devi fornire un link per acquistare l'articolo o caricare il documento</p>
              </div>

              
              <div>
                <x-input-text :required="True" label="Titolo" name="title" value="{{ $article->title }}"/>
              </div>
              {{-- TODO la data di pubblicazine dell'articolo verrà impostata non dall'utente
              ma dal sistema guardando la data di oggi --}}

              <div>
                <x-textarea-quill name="abstract" :required="True" label="Abstract" value="{{ $article->abstract }}"/>
                <p class="mt-3 text-sm/6 text-gray-400">Descrivere con qualche parola l'articolo</p>
              </div>
              
              <div class="mt-4">
                <x-label name="users" :required="True">Authori (minimo 1)</x-label>
                <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
                  @foreach($users as $user)
                      <div class="flex items-center gap-x-3 pr-4">
                          <input 
                            id="user-{{ $user->id }}" 
                            name="users[]" 
                            value="{{ $user->id }}" 
                            type="checkbox" 
                            @checked(in_array($user->id, old('users', $article->users->pluck('id')->toArray())))
                            {{--  --}}
                            class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent">
                          <label for="user-{{ $user->id }}" class="text-sm text-white whitespace-nowrap">
                              {{ $user->name }}
                          </label>
                      </div>
                  @endforeach
                   <x-form-error name="users" />
                </div>
              </div>

              <div class="mt-4">
                <x-label name="areas" :required="True">Area di ricerca dell'articolo (minimo 1)</x-label>
                <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
                  @foreach($areas as $area)
                      <div class="flex items-center gap-x-3 pr-4">
                          <input 
                          id="area-{{ $area->id }}" 
                          name="areas[]" 
                          value="{{ $area->id }}" 
                          type="checkbox" 
                           @checked(in_array($area->id, old('areas', $article->researchAreas->pluck('id')->toArray())))
                          class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent">
                          
                          <label for="area-{{ $area->id }}" class="text-sm text-white whitespace-nowrap">
                              {{ $area->name }}
                          </label>
                      </div>
                  @endforeach
                   <x-form-error name="areas" />
                </div> 
              </div>

              <div>
                <x-label name="link_or_document" :required="True">Scegli tra un documento o un link</x-label>
                 <div class="space-y-3">
                  <div>
                    <x-input-text name="external_url" label="URL" :value="$article->external_url"/>
                  </div>
                  <div>
                    <x-input-file name="file_path" label="Documento"/>
                    <input type="hidden" name="remove_file" value="0"/> 
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <div>
                  <div class="mb-3">
                     @if($article->image_path)
                      <x-label name="image_path">Immagine corrente:</x-label>
                    @else
                      <x-label name="image_path">Seleziona immagine:</x-label>
                    @endif
                    <x-image-preview-articles name="image_path" currentImage="{{ Storage::url($article->image_path) }}"/>
                    <x-form-error name="image_path" />
                  </div>
                </div>
              </div>
            </div>
              
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <x-danger-button form="delete_form" >Elimina</x-danger-button>
          <x-save-button type="submit" >Salva</x-save-button>
        </div>
</form>


</x-layout-menu-bar-private>