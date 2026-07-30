@props([
    'action',
    'method' => 'POST',
    'hasFiles' => false, // Indica se il form contiene campi di tipo file (file upload)
    'title' => '',
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

    <div class="space-y-6 text-white w-full max-w-4xl mx-auto">
        <div class="border-b border-white/10 pb-1">
            @if(isset($header))
                {{ $header }}
            @elseif($title)
                <h1 class="text-base/7 font-semibold text-white">{{ $title }}</h1>
            @endif
        </div>

        <div class="*:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl">
            {{ $slot }}
        </div>
    </div>

    @if(isset($buttons))
        <div class="mt-6 flex items-center justify-end gap-x-4 border-t border-white/10 py-5 w-full max-w-4xl mx-auto">
            {{ $buttons }}
        </div>
    @endif
</form>