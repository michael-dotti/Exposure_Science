<x-layout-private>
    <x-slot:title>
        Editor Profilo
    </x-slot:title>
   <x-form-layout method="PATCH" action="/admin/users/update" :hasFiles="True">
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
              {{ $user->bio }}
            </textarea>
        </div>

        <div>
          <x-label name="curriculm_file_path" :required="False"></x-label>
            <div class="grid md:grid-cols-2 md:gap-6">
            <div>
              <x-input-file name="curriculm_file_path" label="Curriculum Vitae" currentFile="{{ ($user->curriculm_file_path <> 'public/resume/default_resume.pdf')? 'è presente.' : null }}"/>
              <input type="hidden" name="remove_file" value="0"/> 
            </div>
          </div>
        </div>


          <div>
            <x-label name="profile_photo_path">Immagine Profilo</x-label>
            <x-image-preview-users name="profile_photo_path" currentImage="{{ $user->profilePhotoUrl }}"/>
          </div>

          

      <x-slot:buttons>
        <div class="my-4 flex items-center justify-end gap-3">
          <a href="/admin/users/show">
            <x-danger-button type="button" >Annulla</x-danger-button>
          </a>
          <x-save-button type="submit" >Salva</x-save-button>
        </div>
      </x-slot:buttons>

</x-form-layout>

  <hr class="h-1 mb-8 bg-gray-100 border-0 rounded-sm">

    <div class="mt-10 sm:mt-0">
        @livewire('profile.update-password-form')
    </div>

    <x-section-border />

</x-layout-private>