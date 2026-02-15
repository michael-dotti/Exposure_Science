<x-layout-menu-bar-user>
    <x-slot:title>
        New Article 
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/articles" >back</x-link-button>
    </div>
    
    <form method="post" action="/articles" enctype="multipart/form-data">
      @csrf
          <div class="space-y-12">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Create New Article</h2>
              <small>1. Fields marked with * are required</small>
              <small>2. You must provide the item with a link to the purchase page or the document itself</small>
               
              <div>
                <label for="title">Title*</label>
                <input name="title" id="title" type="text" required>
                <x-form-error name="title" />
              </div>
              {{-- TODO la data di pubblicazine dell'articolo verrà impostata non dall'utente
              ma dal sistema guardando la data di oggi --}}

              <div>
                <label for="abstract">Abstract*</label>
                <input name="abstract" id="abstract" type="text" required>
                <x-form-error name="abstract" />
                <p class="mt-3 text-sm/6 text-gray-400">Describe with a few words the article</p>
              </div>
              
              <div class="mt-4">
                <label for="users" class="text-white">Authors* (minimum 1)</label>
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
                   <x-form-error name="users" />
                </div>
                
              </div>

              <div>
                <p>Choose between link or document</p>
                 <div>
                  <div>
                    <label for="external_url">File URL</label>
                    <input name="external_url" id="external_url" type="url">
                    <x-form-error name="external_url" />
                  </div>
                  <div>
                    <label for="file_path">File_path</label>
                    <input name="file_path" id="file_path" type="file">
                    <x-form-error name="file_path" />
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <label for="image_path">Image</label>
                <input type="file" name="image_path" accept="image/*">
              </div>
            </div>
              {{--  
              <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                  <label for="username" class="block text-sm/6 font-medium text-white">Title</label>
                  <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                      <input id="username" type="text" name="username" placeholder="janesmith" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                    </div>
                  </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <label for="users">Autori (seleziona uno o più)</label>
                    <select name="users" id="users" class="form-control" >
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <small>Tieni premuto Ctrl (o Cmd) per selezionare più autori.</small>
                </div>


                <div class="col-span-full">
                  <label for="abstract" class="block text-sm/6 font-medium text-white">Abstract</label>
                  <div class="mt-2">
                    <textarea id="abstract" name="abstract" rows="3" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"></textarea>
                  </div>
                  <p class="mt-3 text-sm/6 text-gray-400">Describe with a few words the article</p>
                </div>


                
                <div class="col-md-6 mb-3">
                    <label for="file_articolo">Carica il file dell'articolo (PDF, DOC)</label>
                    <input type="file" name="file_articolo" id="file_articolo" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="external_url">Oppure inserisci un link esterno (URL)</label>
                    <input type="url" name="external_url" id="external_url" class="form-control" placeholder="https://example.com/acquisto">
                </div>
            
            </div>
            --}}
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/articles">
            <x-button type="button" class="bg-red-800">Cancel</x-button>
          </a>
            <x-button type="submit" class="bg-green-800">Save</x-button>
        </div>
</form>

</x-layout-menu-bar-user>