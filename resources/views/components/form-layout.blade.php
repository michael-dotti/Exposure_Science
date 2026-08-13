@props([
    'action',
    'method' => 'POST',
    'hasFiles' => false,
    'title' => '',
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
                    {{ $header }}
                @elseif ($title)
                    <h1 class="text-base font-semibold text-white">
                        {{ $title }}
                    </h1>
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