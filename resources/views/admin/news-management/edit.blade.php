<x-layout-private>
    <x-slot:title>
        Modifica Notizia
    </x-slot:title>
    
  <x-form-layout action="{{ route('admin.news-management.update',$news->id) }}" method="PATCH" :has-files="true">
      <x-slot:header>
          <h1 class="text-base/7 font-semibold text-white">Modifica notizia</h1>
      </x-slot:header>

      <x-content-section>
        <x-input-text name="title" :required="true" label="Titolo" :value="$news->title"></x-input-text>
        
        <div>
          <x-label :required="true">
            Contenuto
          </x-label>
        </div>


        <div class="">
          <x-textarea-quill name="content" :value="$news->content ?? '' " :required="True"/> {{-- $news->content ?? '' == se esiste content restituisce il suo valore, altrimenti una stringa vuota --}}
        </div>
        
        <div>
          <x-label name="image_path" :required="true">Immagine</x-label>
          <x-image-preview-news name="image_path" currentImage="{{ Storage::url($news->image_path) }}"/>
          <x-form-error name="image_path"/>
        </div>
      </x-content-section>

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