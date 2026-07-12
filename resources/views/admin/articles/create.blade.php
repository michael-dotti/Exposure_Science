<x-layout-menu-bar-private>
    <x-slot:title>
        Nuovo Articolo 
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/admin/articles" >Indietro</x-link-button>
    </div>
    
 
<x-form-layout action="/admin/articles" method="POST" :hasFiles="true">
  <x-slot:header>
    <h1 class="text-base/7 font-semibold text-white">Crea un nuovo Articolo</h2>
      <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
    <p class="text-xs text-gray-400 mt-1">2. Devi fornire un link per acquistare l'articolo o caricare il documento</p>
  </x-slot:header>


    <div>
      <x-input-text :required="True" label="Titolo" name="title"/>
    </div>

    <div>
      <x-textarea-quill name="abstract" :required="True" label="Abstract" />
      <p class="text-sm/6 text-gray-400">Descrivi con alcune parole l'articolo</p>
    </div>

    <div>
      <x-label name="users" :required="True">Autori (minimo 1)</x-label>
      <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
        @foreach($users as $user)
            <div class="flex items-center gap-x-3 pr-4"> 
              <input id="user-{{ $user->id }}" name="users[]" value="{{ $user->id }}" type="checkbox" 
              class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent"
              @checked($user->id == auth()->user()->id)>

                <label for="user-{{ $user->id }}" class="text-sm text-white whitespace-nowrap">
                    {{ $user->name }}
                </label>
            </div>
        @endforeach
          <x-form-error name="users" />
      </div> 
    </div>

    <div >
      <x-label name="areas" :required="True">Area di ricerca dell'articolo (minimo 1)</x-label>
      <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
        @foreach($areas as $area)
            <div class="flex items-center gap-x-3 pr-4">
                <input id="area-{{ $area->id }}" name="areas[]" value="{{ $area->id }}" type="checkbox" 
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
      <div class="grid md:grid-cols-2 md:gap-6">
        <div>
          <x-input-text name="external_url" label="File URL" />
        </div>
        <div>
          <x-input-file name="file_path" label="Documento"/>
        </div>
      </div>
    </div>

    <div>
      <x-label name="image_path">Immagine</x-label>
      <x-image-preview-articles name="image_path" :required="true"/>
      <x-form-error name="image_path" />
    </div>

  <x-slot:buttons>
    <a href="/admin/articles">
      <x-danger-button type="button">Cancel</x-danger-button>
    </a>
    <x-save-button type="submit" >Save</x-save-button>
  </x-slot:buttons>
</x-form-layout>
</x-layout-menu-bar-private>