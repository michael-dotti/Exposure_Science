<x-layout-private>
    <x-slot:title>
		Nuovo evento
    </x-slot:title>
   
    <!-- <form method="post" action="/admin/events-management" enctype="multipart/form-data">
      @csrf
          <div class="space-y-12 text-white">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Nuovo evento</h2>
              <p class="text-xs text-gray-400 mt-1">1. I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
               
              <div>
                <label for="title">Titolo*</label>
                <input name="title" id="title" type="text" required>
                <x-form-error name="title" />
              </div>

              <div>
                <label for="content">Contenuto*</label>
                <input name="content" id="content" type="text" required>
                <x-form-error name="content" />
                <p class="mt-3 text-sm/6 text-gray-400">Inserisci il contenuto dell'evento</p>
              </div>
            </div>

			      <div class="mt-4">
              <label for="users" class="text-white">Destinatari* (minimo 1)</label>
              <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
                @foreach($users as $user)
                    <div class="flex items-center gap-x-3 pr-4">
                        <input id="user-{{ $user->id }}" name="users[]" value="{{ $user->id }}" type="checkbox" 
                              class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent">
                        
                        <label for="user-{{ $user->id }}" class="text-sm text-white whitespace-nowrap">
                            {{ $user->name }}
                        </label>
                    </div>
                @endforeach
              </div> 
                  <x-form-error name="users" />
            </div>
			
			      <div class="mt-4">
              <label for="type" class="text-white">Tipologia Evento*</label>
              <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
                @foreach($types as $type)
                    <div class="flex items-center gap-x-3 pr-4">
                        <input id="type-{{ $type }}" name="type" value="{{ $type }}" type="radio" 
                              class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent">
                        
                        <label for="type-{{ $type }}" class="text-sm text-white whitespace-nowrap">
                            {{ $type->name }}
                        </label>
                    </div>
                @endforeach
                  
              </div> 
              <x-form-error name="type" />
            </div>

            <div class="mt-4">
              <label for="documents">
                Allega documenti:
              </label>
              <input type="file" name="documents[]" id="documents" multiple="">
              <x-form-error name="documents" />
            </div>

          </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/admin/events-management">
            <x-danger-button type="button" >Annulla</x-danger-button>
          </a>
            <x-save-button type="submit" >Salva</x-save-button>
        </div>
</form> -->
  <div class="w-full flex-1 bg-mist-700 shadow-xl rounded-lg flex flex-col overflow-hidden border border-mist-600">
      <div class="min-h-16 py-3 px-4 flex flex-wrap items-center justify-between border-b gap-4 border-white/10 bg-mist-700 shrink-0">  
          <div class="flex flex-wrap gap-2">
            <h4 class="text-md text-gray-200 font-bold wrap-break-word min-w-0"> 
              Scrivi un nuovo evento per comunicare qualcosa al tuo team
            </h4>
          </div>
          <x-link-button href="{{ route('admin.events-management.index') }}" class="my-2">Indietro</x-link-button>
      </div>

      <div class="flex-1 bg-mist-700 p-6 overflow-y-auto custom-scrollbar">
          <x-event-form-layout :action="route('admin.events-management.create')" :hasFiles="True" title="iewnidenm">

            <div>
              <x-input-text label="Titolo" name="title"/>
            </div>

            <div>


            <div>
                <select id="type" name="type" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-s-0 border-default-medium text-heading text-sm rounded-e-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option value="" disabled selected>Scegli un tag da assegnare all'evento</option>
                    @foreach ( $types as $type)
                      <option value="{{ $type->value }}"> {{ $type->value }} </option>
                    @endforeach
                </select>
                <x-form-error name="type" />
            </div>


            </div>

            <div>
              <x-textarea-quill name="content" :required="True"/>
              <x-form-error name="content" />
            </div>

            
            <div class="pt-2">
              <label for="attachments" class="block text-sm font-medium text-gray-200 mb-1">Allega documenti</label>
              <input type="file" name="attachments[]" id="attachments" multiple 
                      class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600">
              <x-form-error name="attachments" />
            </div>

            <x-slot:buttons>
              <a href="{{ route('admin.events-management.index') }}">
                <x-danger-button type="button">Cancella</x-danger-button>
              </a>
              <x-save-button type="submit">Invia</x-save-button>
            </x-slot:buttons>
          </x-event-form-layout>
      </div>
  </div>
</x-layout-private>