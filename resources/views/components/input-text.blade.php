@props(['name',
    'label' => null, // La label è opzionale di default
    'type' => 'text',
    'required' => false
])


<div> {{-- le classi sono già assegnate al div dell'input dal form tramite: *:flex *:flex-col *:gap-y-2 *:mt-6 *:max-w-3xl" --}}
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-white @if($required) after:content-['*'] after:text-red-500 after:ml-0.5 @endif">
            {{ $label }}
        </label>
    @endif

    <input 
    {{ $attributes->merge([
        'type' => $type,
        'name'=> $name,
        'id' => $name,
        'class' => 'rounded-md
    border-0 bg-white/5 p-2 text-white
    shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm w-full'
    ]) }} 
    @required($required)> {{-- @required(condizione) = rende l'input required se la condizione è True --}}

    <x-form-error :name="$name" />
</div>