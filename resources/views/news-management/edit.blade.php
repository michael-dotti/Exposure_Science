<x-layout-menu-bar-private>
    <x-slot:title>
        Modifica News
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/news-management" >Indietro</x-link-button>
    </div>
    
    <form method="POST" action="/news-management/{{ $news->id }}" enctype="multipart/form-data">
      @csrf
       @method('PATCH')
          <div class="space-y-6 text-white">
            <div class="border-b border-white/10 pb-1">
              <h1 class="text-base/7 font-semibold text-white">Modifica Notizia: {{ $news->title }}</h1>
              <div class="mt-1 mb-8">
                <small>I campi con * sono obbligatori</small>
              </div>
            </div>
            
            <div class="*:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl">
              <div>
                <x-input-text name="title" :required="True" label="Titolo" :value="$news->title"></x-input-text>
              </div>

              <div>
                <x-textarea-quill name="content" :value="$news->content ?? '' " label="Contenuto" :required="True" /> {{-- $news->content ?? '' == se esiste content restituisce il suo valore, altrimenti una stringa vuota --}}
              </div>

              <div>
                <x-label name="imagePath" :required="True">Immagine</x-label>
                <x-image-preview-news name="imagePath" currentImage="{{ Storage::url($news->imagePath) }}"/>
                <x-form-error name="imagePath"/>
              </div>
            </div>

          </div>

        <div class="mt-6 flex items-center justify-end gap-x-6 border-t border-white/10 py-5">
          <x-danger-button form="delete_form" >Elimina</x-danger-button>
          <x-save-button type="submit" >Salva</x-save-button>
        </div>
</form>
<form method="POST" action="/news-management/{{ $news->id }}" class="hidden" id="delete_form" >
            @csrf
            @method('DELETE')
          </form>
</x-layout-menu-bar-private>