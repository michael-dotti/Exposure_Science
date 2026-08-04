<x-layout-private>
  <x-slot:title>
    Nuovo evento
  </x-slot:title>
   
  <div class="my-4 w-full flex-1 bg-mist-700 shadow-xl rounded-lg flex flex-col overflow-hidden border border-mist-600">
    

    <div class="flex-1 bg-mist-700 p-6 overflow-y-auto custom-scrollbar">
      <x-event-form-layout :action="route('admin.events-management.store')" :hasFiles="True" title="iewnidenm">

        <div>
          <x-input-text label="Titolo" name="title" :required="true"/>
        </div>

        <div>
          <x-label :required="true">Tag</x-label>
            <select id="type" name="type" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-s-0 border-default-medium text-heading text-sm rounded-e-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
              <option value="" disabled selected>Scegli un tag da assegnare all'evento</option>
              @foreach ( $types as $type)
                <option value="{{ $type->value }}"> {{ $type->value }} </option>
              @endforeach
            </select>
            <x-form-error name="type" />
        </div>
        
        <div>
          <x-event-recipients :users="$users"/>
        </div>

        <div>
          <x-label :required="true">Contenuto dell'evento</x-label>
          <x-textarea-quill name="content" :required="True"/>
          <x-form-error name="content" />
        </div>

        
        <div>
          <x-input-file 
          label="Allegati" 
          name="attachments[]" 
          accept="PDF,DOC,DOCX,JPG,JPEG,WEBP,PNG,PPTX,PPT,ZIP,RAR,TXT,XLS,XLSX"
          :multiple="true"
          />
        </div>

        <x-slot:buttons>
          <x-save-button type="submit">Invia</x-save-button>
          <a href="{{ route('admin.events-management.index') }}">
            <x-danger-button type="button">Cancella</x-danger-button>
          </a>
        </x-slot:buttons>
      </x-event-form-layout>
    </div>
  </div>
</x-layout-private>