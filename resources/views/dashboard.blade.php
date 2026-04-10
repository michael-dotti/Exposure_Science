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


<x-layout-menu-bar-user>
    <x-slot:title>
        Profile
    </x-slot:title>
   <form method="POST" action="dashboard/{{ auth()->user()->id}}">
    @csrf
    @method('PATCH')
    <div class="space-y-12">
      <div class="border-b border-white/10 pb-12">
        <h2 class="text-base/7 font-semibold text-white">Personal Information</h2>
        <p class="mt-1 text-sm/6 text-gray-400">This information will be displayed publicly so be careful what you share.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="first-name" class="block text-sm/6 font-medium text-white">First name</label>
            <div class="mt-2">
              <input id="first-name"
              value="{{ auth()->user()->name }}" 
              type="text" name="first-name" 
              autocomplete="given-name"
              required 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="last-name" class="block text-sm/6 font-medium text-white" >Last name</label>
            <div class="mt-2">
              <input id="last-name" 
              value="{{ auth()->user()->surname }}"
              type="text" 
              name="last-name" 
              autocomplete="family-name" 
              required
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
          </div>

          <div class="sm:col-span-4">
            <label for="email" class="block text-sm/6 font-medium text-white">Email address</label>
            <div class="mt-2">
              <input id="email" 
              value="{{ auth()->user()->email }}"
              type="email" 
              name="email" 
              autocomplete="email"
              required
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
          </div>

          <div class="col-span-full">
            <label for="bio" class="block text-sm/6 font-medium text-white">About</label>
            <div class="mt-2">
              <textarea id="bio" 
              name="bio" 
              rows="4" 
              class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
            {{ auth()->user()->bio }}
            </textarea>
            </div>
            <p class="mt-3 text-sm/6 text-gray-400">Write a few sentences about yourself.</p>
          </div>


          <div class="col-span-full">
            <label for="profile_image" class="block text-sm/6 font-medium text-white">Profile Image</label>
            <div class="mt-2 flex items-center gap-x-3">
              <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-12 text-gray-500">
                <path d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" fill-rule="evenodd" /> 
             </svg>
               <button type="button" class="rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Change</button>
            </div>

            {{-- future put_image_preview components--}}
            {{-- START of the component--}}
            <div class="m-2 p-2 font-sans max-w-200">
              {{-- Preview container --}}
              <div class="mt-1.5 p-1 border-2 border-dashed rounded-lg min-h-75 flex flex-col items-center justify-center">
                <img class="max-w-100% max-h-100 mt-1 rounded-sm shadow-sm " src="" alt="preview">
              </div>
              {{-- File Input --}}
              <input class="m-1 p-0.5 border-2 border-solid rounded-sm cursor-pointer" type="file" name="profile_image" id="profile_image" accept="image/*">
            </div>
            @pushOnce('scripts')
              @vite('resources/js/components/put_image_with_preview.js')  
            @endPushOnce
            {{-- END of the component --}}

          </div>

        </div>
      </div>
  </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button type="button" class="text-sm/6 font-semibold text-white">Cancel</button>
      <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
    </div>
</form>
</x-layout-menu-bar-user>

