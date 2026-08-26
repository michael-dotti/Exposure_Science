@props([
    'action',
    'method' => 'POST',
    'hasFiles' => false,
    'title' => '',
    'button_back' => true,
    'divider' => true, // stabilisce se inserire le linee che separato le diverse parti del form (titolo, input, pulsanti)
    'required_field_note' => true // inserire sotto l'header, al nota che ricorda che i campi con l'asterisco (*) rosso sono obbligatori
])

@php
    $httpMethod = strtoupper($method);

    $isSpoofed = in_array($httpMethod, [
        'PUT',
        'PATCH',
        'DELETE',
    ]);

    $formMethod = $httpMethod === 'GET'
        ? 'GET'
        : 'POST';
@endphp

<form
    method="{{ $formMethod }}"
    action="{{ $action }}"
    @if ($hasFiles)
        enctype="multipart/form-data"
    @endif
    {{ $attributes->merge([
        'class' => 'mt-3 w-full',
    ]) }}
>
    @csrf

    @if ($isSpoofed)
        @method($httpMethod)
    @endif

    <div class="mx-auto w-full max-w-4xl space-y-6 text-white">
        @if (isset($header) || $title)
            <div @class(['pb-4', 'border-b border-white/10' => $divider])> {{-- Applico la linea che divide titolo,input,bottoni nell'input solo se il props divider è true --}}
                @if (isset($header))
                <div class="flex justify-between items-center w-full my-4">
                    <div>
                        {{ $header }}
                        @if ($required_field_note) <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p> @endif
                    </div>

                    @if ($button_back)
                        <div>
                            <x-link-button href="{{ url()->previous() }}">Indietro</x-link-button>
                        </div>
                    @endif
                </div>
            
                @elseif ($title)
                    <h1 class="text-base font-semibold text-white">
                        {{ $title }}
                        @if ($required_field_note) <p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p> @endif
                    </h1>
                    @if ($button_back)
                        <div>
                            <x-link-button href="{{ url()->previous() }}">Indietro</x-link-button>
                        </div>
                    @endif
                @endif
            </div>
        @endif

        <div class="space-y-6">
            {{ $slot }}
        </div>
    </div>

    @if (isset($buttons))
        <div @class([
            'mx-auto mt-6 flex w-full max-w-4xl items-center justify-end gap-x-3 py-5',
            'border-t border-white/10' => $divider
        ])>
            {{ $buttons }}
        </div>
    @endif
</form>