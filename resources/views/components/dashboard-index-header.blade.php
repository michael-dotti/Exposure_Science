@props([
    'title',
    'subtitle'=>'',
    'showSessionStatus' => true
])

@if($showSessionStatus)
    <x-session-status class="mt-3" />
@endif

<div class="my-4 flex flex-col gap-3 md:flex-row sm:items-center sm:justify-between">
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
        <div class="shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>

@if(isset($filters))
    <div>
        {{ $filters }}
    </div>
@endif
