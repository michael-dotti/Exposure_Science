<x-layout-private>
  <x-slot:title>
    Nuovo evento
  </x-slot:title>
   
  <div class="mx-auto w-full max-w-4xl">
      <!-- <x-event-form-layout :action="route('admin.events-management.store')" :hasFiles="True" title="iewnidenm">

        <div>
          <x-input-text label="Titolo" name="title" :required="true"/>
        </div>

        <div>
          <x-label :required="true">Tipo di evento</x-label>
            <select id="type" name="type" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-s-0 border-default-medium text-heading text-sm rounded-e-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
              <option value="" disabled selected>Scegli un tag d'assegnare all'evento</option>
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
      </x-event-form-layout> -->
    <x-form-layout
      :action="route('admin.events-management.store')"
      method="POST"
      :hasFiles="true"
    >

    </x-form-layout>
  </div>
</x-layout-private>