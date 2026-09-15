<a
    {{ $attributes->merge([
        'class' => 'relative inline-flex w-fit items-center justify-center rounded-md border border-gray-300 bg-gray-200 px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-300 hover:text-gray-900 y-400 active:bg-gray-400'
    ]) }}
>
    {{ $slot }}
</a>