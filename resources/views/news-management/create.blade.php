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
              <small>1. I campi con * sono obbligatori</small>
               
              <div>
                <label for="title">Titolo*</label>
                <input name="title" id="title" type="text" required>
                <x-form-error name="title" />
              </div>
              {{-- TODO la data di pubblicazine dell'articolo verrà impostata non dall'utente
              ma dal sistema guardando la data di oggi --}}

              <div>
                <label for="content">Contenuto*</label>
                <input name="content" id="content" type="text" required>
                <x-form-error name="content" />
                <p class="mt-3 text-sm/6 text-gray-400">Inserisci il contenuto dell'articolo</p>
              </div>

              <div class="mt-6">
                <label for="imagePath">Image</label>
                <x-image-preview-articles name="imagePath" currentImage=""/>
              </div>
            </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/articles">
            <x-button type="button" class="bg-red-800">Cancel</x-button>
          </a>
            <x-button type="submit" class="bg-green-800">Save</x-button>
        </div>
</form>

</x-layout-menu-bar-private>