{{-- 
    Componente Input Riutilizzabile
    -------------------------------------------------------------------------
    $name     - Nome, ID e chiave per la validazione dell'input
    $type     - Tipo di input (default: 'text')
    $value    - Valore iniziale (utile per i form di modifica)
    $label    - Testo della label. Se omesso, la label non viene renderizzata
    $required - Se true, rende l'input obbligatorio e aggiunge un "*" rosso alla label 
--}}


@props(['name',
    'type' => 'text',
    'value'=> '',
     'label' => null, // La label è opzionale di default
    'required' => false,
])


<div> {{-- le classi sono già assegnate al div dell'input dal form tramite: *:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl" --}}
    @if($label)
        <x-label :name="$name" :required="$required">
            {{ $label }}
        </x-label>
    @endif

    <input 
    {{ $attributes->merge([
        'type' => $type,
        'name'=> $name,
        'id' => $name,
        'class' => 'rounded-md
    border-0 bg-white/5 p-2 text-white
    shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm w-full',
    ]) }} 
    value="{{ old($name, $value) }}"  {{--  se l'utente ha già inserito un valore, lo mantiene in caso di errore di validazione --}}
    @required($required)> {{-- @required(condizione) = rende l'input required se la condizione è True --}}

    <x-form-error :name="$name" />
</div>