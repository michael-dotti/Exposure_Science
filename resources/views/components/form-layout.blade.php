@props([
    'action',
    'method' => 'POST',
    'hasFiles' => false,
    'title' => '',
    'button_indietro' => true
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
            <div class="border-b border-white/10 pb-4">
                @if (isset($header))
                <div class="flex justify-between items-center w-full my-4">
                    <div>
                        {{ $header }}
                    </div>

                    @if ($button_indietro)
                        <div>
                            <x-link-button href="{{ url()->previous() }}">indietro</x-link-button>
                        </div>
                    @endif
                </div>
            
                @elseif ($title)
                    <h1 class="text-base font-semibold text-white">
                        {{ $title }}
                    </h1>
                    @if ($button_indietro)
                        <div>
                            <x-link-button href="{{ url()->previous() }}">indietro</x-link-button>
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
        <div class="mx-auto mt-6 flex w-full max-w-4xl items-center justify-end gap-x-3 border-t border-white/10 py-5">
            {{ $buttons }}
        </div>
    @endif
</form>