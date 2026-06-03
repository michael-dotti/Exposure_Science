<x-layout-menu-bar-private>
    <x-slot:title>
        Modifica Articolo
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/articles" >Indietro</x-link-button>
    </div>
    
    <form method="POST" action="/articles/{{ $article->id }}" enctype="multipart/form-data">
      @csrf
       @method('PATCH')
          <div class="space-y-12 text-white">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Modifica Articolo: {{ $article->title }}</h2>
              <div class="mt-1 mb-8">
                <small>1. I campi con * sono obbligatori</small>
                <br>
                <small>2. Bisogna mettere a disposizione il link per l'acquisto dell'articolo o l'articolo stesso sotto forma di documento</small>
              </div>

              
              <div>
                <label for="title">Titolo*</label>
                <input name="title" id="title" type="text" required value="{{ $article->title }}">
                <x-form-error name="title" />
              </div>
              {{-- TODO la data di pubblicazine dell'articolo verrà impostata non dall'utente
              ma dal sistema guardando la data di oggi --}}

              <div>
                <label for="abstract">Astratto*</label>
                <input name="abstract" id="abstract" type="text" required value="{{ $article->abstract }}">
                <x-form-error name="abstract" />
                <p class="mt-3 text-sm/6 text-gray-400">Descrivere con qualche parola l'articolo</p>
              </div>
              
              <div class="mt-4">
                <label for="users" class="text-white">Autori* (minimo 1)</label>
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
                <label for="area" class="text-white">Area di ricerca dell'articolo* (minimo 1)</label>
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
                <p>Selezionare link o documento</p>
                 <div>
                  <div>
                    <label for="external_url">URL</label>
                    <input name="external_url" id="external_url" type="url" value="{{ $article->external_url }}">
                    <x-form-error name="external_url" />
                  </div>
                  <div>
                    <label for="file_path">Documento</label>
                    <input name="file_path" id="file_path" type="file">
                    <input type="hidden" name="remove_file" value="0"/> 
                    <x-form-error name="file_path" />
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <div>
                  
                      <div class="mb-3">
                        @if($article->image_path)
                          <p class="text-md text-yellow-300">Immagine corrente:</p>
                        @else
                          <p class="text-md text-yellow-300">Selezionare immagine:</p>
                        @endif
                        <x-image-preview-articles name="image_path" currentImage="{{ Storage::url($article->image_path) }}"/>
                        <x-form-error name="image_path" />
                      </div>
                </div>
              </div>
            </div>
              
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/articles">
            <!--TODO: implementare pulsante elimina-->
            <x-button type="button" class="bg-red-800">Elimina</x-button>
          </a>
          <x-button type="submit" class="bg-green-800">Salva</x-button>
        </div>
</form>

</x-layout-menu-bar-private>