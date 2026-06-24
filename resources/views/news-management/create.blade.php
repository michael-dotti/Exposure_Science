<x-layout-menu-bar-private>
    <x-slot:title>
		Nuova notizia
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/news-management" >back</x-link-button>
    </div>
    
    <form method="post" action="/news-management" enctype="multipart/form-data">
      @csrf
      <div class="space-y-12 text-white">
        <div class="border-b border-white/10 pb-12">
          <h1 class="text-base/7 font-semibold text-white">Nuova notizia</h2>
          <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>

          <div class="*:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl">
            <div>
              <x-input-text name="title" :required="True" label="Titolo"></x-input-text>
            </div>

            <div>
              <x-textarea-quill name="content" />
            </div>
            
            <div>
              <x-label name="imagePath" :required="True">Immagine</x-label>
              <x-image-preview-news name="imagePath"/>
              <x-form-error name="imagePath"/>
            </div>
          </div>

        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="/news-management">
          <x-danger-button type="button" >Annulla</x-danger-button>
        </a>
          <x-save-button type="submit" >Salva</x-save-button>
      </div>
    </form>

</x-layout-menu-bar-private>