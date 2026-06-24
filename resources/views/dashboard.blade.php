{{-- 
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>     

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
--}}


<x-layout-menu-bar-private>
    <x-slot:title>
        Profile
    </x-slot:title>
   <form method="POST" action="dashboard/{{ auth()->user()->id}}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="space-y-12">
      <div class="border-b border-white/10 pb-12">
        <h2 class="text-base/7 font-semibold text-white">Personal Information</h2>
        <p class="mt-1 text-sm/6 text-gray-400">This information will be displayed publicly so be careful what you share.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <x-input-text name="name" value="{{ auth()->user()->name }}" :required="True" label="Nome"/>
          </div>

          <div class="sm:col-span-3">
            <x-input-text name="surname" value="{{ auth()->user()->surname }}" :required="True" label="Cognome"/>
          </div>

          <div class="col-span-full">
            <label for="bio" class="block text-sm/6 font-medium text-white">About</label>
            <div class="mt-2">
              <textarea id="bio" 
              name="bio" 
              rows="4" 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
            {{ auth()->user()->bio }}
            </textarea>
            </div>
            <p class="mt-3 text-sm/6 text-gray-400">Write a few sentences about yourself.</p>
          </div>


          <div class="col-span-full">
            <p class="block text-sm/6 font-medium text-white">Profile Image</p>
            <x-image-preview-users name="profile_photo_path" currentImage="{{ auth()->user()->profilePhotoUrl }}"/>
          </div>

        </div>
      </div>
  </div>

    <div class="my-4 flex items-center justify-end gap-3">
      <x-danger-button type="button" >Cancel</x-danger-button>
      <x-save-button type="submit" >Save</x-save-button>
    </div>
</form>
</x-layout-menu-bar-private>

