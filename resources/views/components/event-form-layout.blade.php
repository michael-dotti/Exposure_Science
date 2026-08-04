@props([
    'action',
    'method' => 'POST',
    'hasFiles' => false, // Indica se il form contiene campi di tipo file (file upload)
])

@php
    // Gestione dei metodi HTTP "spoofed" di Laravel (PUT, PATCH, DELETE)
    $httpMethod = strtoupper($method); // Convertiamo il metodo in maiuscolo 
    $isSpoofed = in_array($httpMethod, [ 'PATCH', 'DELETE']); // restituisce true se il metodo è PATCH o DELETE (cioè è un metodo che richiede lo spoofing)
    $formMethod = $httpMethod === 'GET' ? 'GET' : 'POST'; // Se il metodo è GET, usiamo GET, altrimenti POST, alla fine del form aggiungeremo un campo nascosto con il metodo corretto se necessario
@endphp

<form 
    method="{{ $formMethod }}" 
    action="{{ $action }}" 
    @if($hasFiles) enctype="multipart/form-data" @endif
    {{ $attributes->merge(['class'=>'w-full mt-3']) }}
>
    @csrf
    @if($isSpoofed)
        @method($httpMethod)
    @endif

    <div class="space-y-3 text-white w-full max-w-4xl mx-auto">
        
        <div class="flex items-start justify-between mb-8 max-w-3xl"> 
            <div>
                <h1 class="text-md font-semibold text-white">Scrivi un nuovo evento per comunicare qualcosa al team</h1>
                <p class="text-sm text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
            </div>
            
            <x-link-button href="{{ route('admin.events-management.index') }}" class="my-2">Indietro</x-link-button>
        </div>

        <div class="*:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl">
            {{ $slot }}
        </div>
    </div>

    @if(isset($buttons))
        <div class="mt-6 flex items-center justify-end gap-x-6 border-t border-white/10 py-5 w-full max-w-4xl mx-auto">
            {{ $buttons }}
        </div>
    @endif
</form>