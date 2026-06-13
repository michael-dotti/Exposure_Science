<x-layout-menu-bar-private>
    <x-slot:title>
		Nuovo evento
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/events-management" >back</x-link-button>
    </div>
    
    <form method="post" action="/events-management" enctype="multipart/form-data">
      @csrf
          <div class="space-y-12 text-white">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Nuovo evento</h2>
              <small>1. I campi con * sono obbligatori</small>
               
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
        
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/events-management">
            <x-danger-button type="button" >Annulla</x-danger-button>
          </a>
            <x-save-button type="submit" >Salva</x-save-button>
        </div>
</form>

</x-layout-menu-bar-private>