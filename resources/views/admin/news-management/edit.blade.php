<x-layout-private>
    <x-slot:title>
        Modifica News
    </x-slot:title>
    
  <x-form-layout action="{{ route('admin.news-management.update',$news->id) }}" method="PATCH" :has-files="true">
      <x-slot:header>
          <h1 class="text-base/7 font-semibold text-white">Modifica notizia</h1>
          <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
      </x-slot:header>

      <div>
        <x-input-text name="title" :required="true" label="Titolo" :value="$news->title"></x-input-text>
      </div>

      <div>
        <x-textarea-quill name="content" :value="$news->content ?? '' " :required="True"/> {{-- $news->content ?? '' == se esiste content restituisce il suo valore, altrimenti una stringa vuota --}}
      </div>
      
      <div>
        <x-label name="image_path" :required="true">Immagine</x-label>
        <x-image-preview-news name="image_path" currentImage="{{ Storage::url($news->image_path) }}"/>
        <x-form-error name="image_path"/>
      </div>
      
      <x-slot:buttons>
        <x-save-button type="submit">Salva</x-save-button>
        <x-danger-button form="delete_form">Elimina</x-danger-button>
      </x-slot:buttons>

    </x-form-layout>
  <form method="POST" action="{{ route('admin.news-management.destroy',$news->id) }}" class="hidden" id="delete_form" >
    @csrf
    @method('DELETE')
  </form>
</x-layout-private>