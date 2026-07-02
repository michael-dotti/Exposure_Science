<x-layout-menu-bar-private>
    <x-slot:title>
        New Article 
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/articles" >back</x-link-button>
    </div>
    
    <form method="post" action="/articles" enctype="multipart/form-data">
      @csrf
          <div class="space-y-12 text-white">
            <div class="border-b pb-12">
              <h1 class="text-base/7 font-semibold text-white">Create New Article</h2>
               <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
              <p class="text-xs text-gray-400 mt-1">2. Devi fornire un link per acquistare l'articolo o caricare il documento</p>
              <div>
                <x-input-text :required="True" label="Title" name="title"/>
              </div>
              

              <div>
                 <x-textarea-quill name="abstract" :required="True" label="Abstract" />
                <p class="mt-3 text-sm/6 text-gray-400">Descrivi con alcune parole l'articolo</p>
              </div>
              
              <div class="mt-4">
                <x-label name="users" :required="True">Authors (minimo 1)</x-label>
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

              <div class="mt-4">
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
                 <div>
                  <div>
                    <x-input-text name="external_url" label="File URL" />
                  </div>
                  <div>
                    <label for="file_path">Documento</label>
                    <input name="file_path" id="file_path" type="file">
                    <x-form-error name="file_path" />
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <x-label name="image_path" :required="True">Immagine</x-label>
                <x-image-preview-articles name="image_path" currentImage=""/>
                <x-form-error name="image_path" />
              </div>
            </div>
              
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/articles">
            <x-danger-button type="button">Cancel</x-danger-button>
          </a>
            <x-save-button type="submit" >Save</x-save-button>
        </div>
</form>

</x-layout-menu-bar-private>