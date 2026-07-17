<x-layout-menu-bar-private>
    <x-slot:title>
        Editor Profilo
    </x-slot:title>
   <x-form-layout method="PATCH" action="/dashboard/{{ auth()->user()->id}}" :hasFiles="True">
        <x-slot:header>
          <h2 class="text-base/7 font-semibold text-white">Informazioni Personali</h2>
          <p class="mt-1 text-sm/6 text-gray-400">Le informazioni che inserisci saranno rese pubbliche, fai attenzione a ciò che inserisci.</p>
        </x-slot:header>
        
        <div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <x-input-text name="name" value="{{ auth()->user()->name }}" :required="True" label="Nome"/>
            <x-input-text name="surname" value="{{ auth()->user()->surname }}" :required="True" label="Cognome"/>
          </div>
        </div>

        <x-input-text name="email" value="{{ auth()->user()->email }}" :required="True" label="Email"/>
        <x-input-text name="website" value="{{ auth()->user()->website }}" :required="False" label="Sito Web"/>

        <div class="col-span-full">
          <x-label name="bio">Raccontaci qualcosa di te:</x-label>
            <textarea id="bio" 
              name="bio" 
              rows="4" 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
              {{ auth()->user()->bio }}
            </textarea>
        </div>


          <div>
            <x-label name="profile_photo_path">Immagine Profilo</x-label>
            <x-image-preview-users name="profile_photo_path" currentImage="{{ auth()->user()->profilePhotoUrl }}"/>
          </div>

      <x-slot:buttons>
        <div class="my-4 flex items-center justify-end gap-3">
          <a href="/dashboard">
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

</x-layout-menu-bar-private>