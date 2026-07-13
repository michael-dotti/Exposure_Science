<x-layout-menu-bar-private>
    <x-slot:title>
        Modifica News
    </x-slot:title>
    
  <x-form-layout action="/admin/news-management/{{ $news->id }}" method="PATCH" :has-files="true">
      <x-slot:header>
        <div class="flex justify-between items-center w-full my-5">
          <div>
            <h1 class="text-base/7 font-semibold text-white">Modifica notizia</h1>
            <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
          </div>

          <div>
            <x-link-button href="/admin/news-management">Indietro</x-link-button>
          </div>
        </div>
      </x-slot:header>

      <div>
        <x-input-text name="title" :required="true" label="Titolo" :value="$news->title"></x-input-text>
      </div>

      <div>
        <x-textarea-quill name="content" :value="$news->content ?? '' " :required="True"/> {{-- $news->content ?? '' == se esiste content restituisce il suo valore, altrimenti una stringa vuota --}}
      </div>
      
      <div>
        <x-label name="imagePath" :required="true">Immagine</x-label>
        <x-image-preview-news name="imagePath" currentImage="{{ Storage::url($news->imagePath) }}"/>
        <x-form-error name="imagePath"/>
      </div>
      
      <x-slot:buttons>
        <x-danger-button form="delete_form">Elimina</x-danger-button>
        <x-save-button type="submit">Salva</x-save-button>
      </x-slot:buttons>

    </x-form-layout>
  <form method="POST" action="/admin/news-management/{{ $news->id }}" class="hidden" id="delete_form" >
    @csrf
    @method('DELETE')
  </form>
</x-layout-menu-bar-private>