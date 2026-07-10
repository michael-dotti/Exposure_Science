<x-layout-menu-bar-private>
    <x-slot:title>
        Profile
    </x-slot:title>
   <x-form-layout method="PATCH" action="/dashboard/{{ auth()->user()->id}}" :hasFiles="True">
        <x-slot:header>
          <h2 class="text-base/7 font-semibold text-white">Personal Information</h2>
          <p class="mt-1 text-sm/6 text-gray-400">This information will be displayed publicly so be careful what you share.</p>
        </x-slot:header>
        
        <div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <x-input-text name="name" value="{{ auth()->user()->name }}" :required="True" label="Nome"/>
            <x-input-text name="surname" value="{{ auth()->user()->surname }}" :required="True" label="Cognome"/>
          </div>
        </div>

        <x-input-text name="email" value="{{ auth()->user()->email }}" :required="True" label="Email"/>

        <div class="col-span-full">
          <x-label name="bio">About</x-label>
            <textarea id="bio" 
              name="bio" 
              rows="4" 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
              {{ auth()->user()->bio }}
            </textarea>
          <p class="mt-1 text-sm/6 text-gray-400">Parla un pò di te.</p>
        </div>


          <div>
            <x-label name="profile_photo_path">Profile Image</x-label>
            <x-image-preview-users name="profile_photo_path" currentImage="{{ auth()->user()->profilePhotoUrl }}"/>
          </div>

      <x-slot:buttons>
        <div class="my-4 flex items-center justify-end gap-3">
          <a href="/dashboard">
            <x-danger-button type="button" >Cancel</x-danger-button>
          </a>
          <x-save-button type="submit" >Save</x-save-button>
        </div>
    </x-slot:buttons>

</x-form-layout>
</x-layout-menu-bar-private>