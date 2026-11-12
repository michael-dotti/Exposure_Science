<x-layout-private>
    <x-slot:title>
        Editor Profilo
    </x-slot:title>
   <x-form-layout method="PATCH" action="{{ route('admin.users.update',$user->id) }}" :hasFiles="true">
        <x-slot:header>
          <h2 class="text-base/7 font-semibold text-white">Informazioni Personali</h2>
          <p class="mt-1 text-sm/6 text-gray-400">Le informazioni che inserisci saranno rese pubbliche, fai attenzione a ciò che inserisci.</p>
        </x-slot:header>
        
        <div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <x-input-text name="name" value="{{ $user->name }}" :required="True" label="Nome"/>
            <x-input-text name="surname" value="{{ $user->surname }}" :required="True" label="Cognome"/>
          </div>
        </div>


        <x-input-text name="email" value="{{ $user->email }}" :required="True" label="Email"/>
        <x-input-text name="website" value="{{ $user->website }}" :required="False" label="Sito Web"/>


        <div class="col-span-full">
          <x-label name="bio">Raccontaci qualcosa di te</x-label>
            <textarea id="bio" 
              name="bio" 
              rows="4" 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
              {{ old('bio', $user->bio) }}
            </textarea>
            <p class="text-xs text-gray-500 mt-1">Massimo 500 caratteri.</p>

            <x-form-error name="bio" />
        </div>

        <div>
          <x-label name="curriculm_file_path" :required="False">Il tuo curriculum:</x-label>
          @if ($user->curriculum)
          <div class="ml-8 items-center flex gap-4">
            <x-button-open-file :file="$user->curriculum" buttonText="Apri file attuale"/>
            
            <x-input-file
                          name="curriculum" 
                          :currentImage="$user->curriculum->file_name"
                          label="Carica un nuovo CV"
                          />
            
          </div>
          @else
          <div class="ml-8 flex flex-col gap-2">
            <p class="text-base/7 text-gray-500 ml-8 italic"> [non hai inserito nessun CV a tuo nome] </p>
            <x-input-file
                name="curriculum" 
                label="Carica il tuo primo CV"
            />
          </div>
          @endif
          
          <input type="hidden" name="remove_file" value="0"/> 
        </div>
          
        


          <div>
            <x-label name="profile_photo_path">Immagine Profilo</x-label>
            <x-image-preview-users name="profile_photo_path" currentImage="{{ $user->profilePhotoUrl }}"/>
          </div>

          

      <x-slot:buttons>
        <div class="my-4 flex items-center justify-end gap-3">
          <x-save-button type="submit" >Salva</x-save-button>
          <a href="/admin/users/show">
            <x-danger-button type="button" >Annulla</x-danger-button>
          </a>
        </div>
      </x-slot:buttons>

</x-form-layout>

  <div class="mx-auto w-full max-w-4xl mt-7 border-t-4 border-white/60 pt-6 pb-8">
      @livewire('profile.update-password-form')
  </div>  

</x-layout-private>