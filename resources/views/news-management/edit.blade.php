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
          <div class="space-y-12 text-white">
            <div class="border-b border-white/10 pb-1">
              <h1 class="text-base/7 font-semibold text-white">Modifica Notizia: {{ $news->title }}</h1>
              <div class="mt-1 mb-8">
                <small>1. I campi con * sono obbligatori</small>
              </div>
            </div>
              
            <div>
                <label for="title">Titolo*</label>
                <input name="title" id="title" type="text" required value="{{ $news->title }}">
                <x-form-error name="title" />
            </div>

            <div>
                <label for="content">Contenuto*</label>
                <input name="content" id="content" type="text" required value="{{ $news->content }}">
                <x-form-error name="content" />
                <p class="mt-3 text-sm/6 text-gray-400">Descrivere con qualche parola l'articolo</p>
            </div>

			      <div class="mt-6">
                <div>
                      <div class="mb-3">
                        <p class="text-md text-yellow-300">Immagine corrente*:</p>
                        <x-image-preview-news name="imagePath" currentImage="{{ Storage::url($news->imagePath) }}"/>
                        <x-form-error name="imagePath" />
                      </div>
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