@props(['name'])

<input type="file" 
name="{{ $name }}" 
id="imageUpload" 
accept="image/*"
class="hidden">

<label for="imageUpload"
    class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 transition ease-in-out duration-150 cursor-pointer">
    Inserisci
</label>
