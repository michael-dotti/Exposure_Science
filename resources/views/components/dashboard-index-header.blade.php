@props([
    'title',
    'subtitle'=>''
])

<div class="my-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-bold text-white">
            {{ $title }}
        </h1>

        @if($subtitle)
            <p class="mt-1 text-xs text-gray-400">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    @if(isset($actions)) {{-- verifica se l'utente non vuole dei bottoni nel componente --}}
        <div>
            {{ $actions }}
        </div>
    @endif
</div>

@if(isset($filters))
    <div>
        {{ $filters }}
    </div>
@endif
