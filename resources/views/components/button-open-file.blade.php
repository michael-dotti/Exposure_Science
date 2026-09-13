@props([
    'file',
    'text' => null,
    'buttonText' => 'Apri',
])

<div
    {{ $attributes->class([
        'flex flex-col items-start gap-3 mt-2'
    ]) }}
>
    @if ($text)
        <p class="max-w-md text-base font-medium leading-6 text-gray-200">
            {{ $text }}
        </p>
    @endif

    <a
        href="{{ route('files.show', $file->id) }}"
        title="{{ $file->file_name }}"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex min-w-28 items-center justify-center gap-2 rounded-xl
               bg-cyan-500 px-5 py-3 font-semibold text-white shadow-md
               transition duration-200 hover:bg-cyan-600
               focus:outline-none focus:ring-2 focus:ring-cyan-400
               focus:ring-offset-2 focus:ring-offset-gray-800"
    >
        <i
            class="fa-solid fa-arrow-up-right-from-square"
            aria-hidden="true"
        ></i>

        <span>{{ $buttonText }}</span>
    </a>
</div>