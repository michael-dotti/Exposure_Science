<x-layout-menu-bar-user>
    <x-slot:title>
        Article edit 
    </x-slot:title>
   
    <div class="flex justify-end">
        <x-link-button href="/articles" >back</x-link-button>
    </div>
    
    <form method="POST" action="/articles/{{ $article->id }}" enctype="multipart/form-data">
      @csrf
       @method('PATCH')
          <div class="space-y-12">
            <div class="border-b border-white/10 pb-12">
              <h1 class="text-base/7 font-semibold text-white">Edit Article: {{ $article->title }}</h2>
              <small>1. Fields marked with * are required</small>
              <small>2. You must provide the item with a link to the purchase page or the document itself</small>
               
              <div>
                <label for="title">Title*</label>
                <input name="title" id="title" type="text" required value="{{ $article->title }}">
                <x-form-error name="title" />
              </div>
              {{-- TODO la data di pubblicazine dell'articolo verrà impostata non dall'utente
              ma dal sistema guardando la data di oggi --}}

              <div>
                <label for="abstract">Abstract*</label>
                <input name="abstract" id="abstract" type="text" required value="{{ $article->abstract }}">
                <x-form-error name="abstract" />
                <p class="mt-3 text-sm/6 text-gray-400">Describe with a few words the article</p>
              </div>
              
              <div class="mt-4">
                <label for="users" class="text-white">Authors* (minimum 1)</label>
                <div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
                  @foreach($users as $user)
                      <div class="flex items-center gap-x-3 pr-4">
                          <input 
                            id="user-{{ $user->id }}" 
                            name="users[]" 
                            value="{{ $user->id }}" 
                            type="checkbox" 
                            @checked(in_array($user->id, old('users', $article->users->pluck('id')->toArray())))
                            {{--  --}}
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
                    <input name="external_url" id="external_url" type="url" value="{{ $article->external_url }}">
                    <x-form-error name="external_url" />
                  </div>
                  <div>
                    <label for="file_path">File_path</label>
                    <input name="file_path" id="file_path" type="file" value="{{ $article->file_path }}">
                    <x-form-error name="file_path" />
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <div>
                  @if($article->image_path)
                      <div class="mb-3">
                        <p class="text-md text-yellow-300">Current image: {{ $article->image_path }}</p>
                        <img src="{{ asset('storage/'.$article->image_path) }}" alt="Preview" class="max-w-64 h-auto rounded">
                      </div>
                  @endif
                </div>
                <div>
                  <label for="image_path">Image</label>
                  <input type="file" name="image_path" accept="image/*">
                </div>
              </div>
            </div>
              
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="/articles">
            <x-button type="button" class="bg-red-800">Cancel</x-button>
          </a>
          <x-button type="submit" class="bg-green-800">Update</x-button>
        </div>
</form>

</x-layout-menu-bar-user>