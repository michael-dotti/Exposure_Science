<x-layout-private>
    <x-slot:title>
		Nuova notizia
    </x-slot:title>
   
    
    <x-form-layout action="{{ route('admin.news-management.store') }}" method="POST" :has-files="true">
      
      <x-slot:header>
        <h1 class="text-base/7 font-semibold text-white">Nuova notizia</h1>
        <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
      </x-slot:header>

      <x-content-section>
        <x-input-text name="title" :required="true" label="Titolo" />
        
        <div class="mt-4">
          <x-textarea-quill name="content" label="Contenuto Della Notizia" :required="true" />
        </div>
        
        <div>
          <x-label name="image_path" :required="true">Immagine</x-label>
          <x-image-preview-news name="image_path"/>
          <x-form-error name="image_path"/>
        </div>
      </x-content-section>

      @if ($errors->any())
        <div class="space-y-2 mb-4">
            @foreach ($errors->all() as $error)
                <x-error-message>{{ $error }}</x-error-message>
            @endforeach
        </div>
      @endif
      
      <x-slot:buttons>
        <x-save-button type="submit">Salva</x-save-button>
        <a href="{{ route('admin.news-management.index') }}">
          <x-danger-button type="button">Annulla</x-danger-button>
        </a>
      </x-slot:buttons>

    </x-form-layout>

</x-layout-private>