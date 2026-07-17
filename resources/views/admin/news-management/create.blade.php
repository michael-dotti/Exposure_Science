<x-layout-private>
    <x-slot:title>
		Nuova notizia
    </x-slot:title>
   
    
    <x-form-layout action="/admin/news-management" method="POST" :has-files="true">
      
      <x-slot:header>
        <div class="flex justify-between items-center w-full my-5">
          <div>
            <h1 class="text-base/7 font-semibold text-white">Nuova notizia</h1>
            <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
          </div>

          <div>
            <x-link-button href="/admin/news-management">back</x-link-button>
          </div>
        </div>
      </x-slot:header>

      <div>
        <x-input-text name="title" :required="true" label="Titolo"></x-input-text>
      </div>

      <div>
        <x-textarea-quill name="content" />
      </div>
      
      <div>
        <x-label name="imagePath" :required="true">Immagine</x-label>
        <x-image-preview-news name="imagePath"/>
        <x-form-error name="imagePath"/>
      </div>
      
      <x-slot:buttons>
        <a href="/admin/news-management">
          <x-danger-button type="button">Annulla</x-danger-button>
        </a>
        <x-save-button type="submit">Salva</x-save-button>
      </x-slot:buttons>

    </x-form-layout>

</x-layout-private>