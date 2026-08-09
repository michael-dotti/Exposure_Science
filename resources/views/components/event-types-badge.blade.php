@props(['type'])

@if ($type == 'Task')
    <span class="bg-neutral-primary-soft text-heading text-xs font-medium px-1.5 py-0.5 rounded">Task</span>
@elseif ($type == 'Attenzione')
    <span class="bg-danger-soft text-fg-danger-strong text-xs font-medium px-1.5 py-0.5 rounded">Attenzione!</span>
@elseif ($type == 'Novità')
    <span class="bg-brand-softer text-fg-brand-strong text-xs font-medium px-1.5 py-0.5 rounded">Novità</span>
@elseif ($type == 'Riunione')
    <span class="bg-warning-soft text-fg-warning text-xs font-medium px-1.5 py-0.5 rounded">Riunione</span>
@endif
