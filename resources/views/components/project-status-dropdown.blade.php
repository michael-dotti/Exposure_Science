@props([
    'statuses',
    'name' => 'status',
    'label' => 'Stato',
    'required' => true,
    'selected' => null
])

@php
    $currentValue = old($name, (is_object($selected) ? $selected->value : $selected) ?? ($statuses[0]->value ?? null));
    
    $currentEnum = collect($statuses)->first(fn($s) => $s->value === $currentValue) ?? ($statuses[0] ?? null);
    $currentLabel = $currentEnum?->label() ?? 'Seleziona...';
@endphp

<div class="relative inline-block status-dropdown-wrapper">
    <x-label :name="$name" :required="$required">{{ $label }}</x-label>
    
    {{-- Input nascosto per il salvataggio dei dati nel form --}}
    <input type="hidden" name="{{ $name }}" class="status-hidden-input" value="{{ $currentValue }}">

    <x-dropdown align="left" width="w-max">
        <x-slot name="trigger">
            <button type="button" class="relative bg-white/5 py-2 pl-2 pr-8 rounded-md border border-white/10 text-white hover:bg-white/10 focus:outline-none w-max text-start mt-1">
                <span class="status-current-label">
                    {{ $currentLabel }}
                </span>
                
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="size-4 text-gray-400">
                        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </span>
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="py-1">
                @foreach($statuses as $status)
                    <x-dropdown-link href="javascript:void(0)" 
                        data-value="{{ $status->value }}" 
                        class="status-option-btn">
                        {{ $status->label() }}
                    </x-dropdown-link>
                @endforeach
            </div>
        </x-slot>
    </x-dropdown>

    <x-form-error :name="$name" />
</div>


@pushOnce('scripts')
    @vite('resources/js/components/project-status-dropdown.js')  
@endPushOnce