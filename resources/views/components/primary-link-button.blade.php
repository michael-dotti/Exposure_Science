{{-- Componentente ancora <a> altamente personalizzabile
    Spiegazione props
    - text = aggiunge un paragrafo prima del <a>
    - title = aggiunge l'attributo title (quando l'utente si ferma sul mouse al link, vede un testo apparire)
    - href (OBBLIGATORIO!) = passi la rotta che vuoi utilizzare
    - icon = La classe dell'icona del fontAwesom che vuoi usare 
    
    Il componente richiede poi:
    di inserire il testo del tag <a> dentro lo $slot
    
    Puoi modificare la grafica del componente <a> perché ho utilizzato
    $attributes
    
     --}}

@props([
    'text'=>null,
    'title'=> null, 
    'href',
    'icon'=> null
])

@if ($text)
    <p class="text-white font-medium mb-2 mt-2">{{ $text }}</p>
@endif
<a  
    href="{{ $href }}" 
    @if($title) 
        title="{{ $title }}" 
    @endif
    {{ $attributes->merge(['class'=>'inline-flex items-center w-fit gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg shadow transition']) }}
>
    @if ($icon)
        <i class="{{ $icon }} w-4 h-4 fill-current shrink-0"></i>
    @endif 

    {{-- Testo del bottone --}}
    {{ $slot }}
</a>