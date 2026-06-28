@props(['type'])

@if ($type == 'task')
    <span class="bg-neutral-primary-soft text-heading text-xs font-medium px-1.5 py-0.5 rounded">Task</span>
@elseif ($type == 'warning')
    <span class="bg-danger-soft text-fg-danger-strong text-xs font-medium px-1.5 py-0.5 rounded">Attenzione!</span>
@elseif ($type == 'news')
    <span class="bg-brand-softer text-fg-brand-strong text-xs font-medium px-1.5 py-0.5 rounded">Novità</span>
@elseif ($type == 'meeting')
    <span class="bg-success-soft text-fg-success-strong text-xs font-medium px-1.5 py-0.5 rounded">Riunione</span>
@endif

<!--  
    case TASK = 'task';
    case WARNING = 'warning';
    case NEWS = 'news';
    case MEETING = 'meeting'; -->
<!-- 
<span class="bg-brand-softer text-fg-brand-strong text-xs font-medium px-1.5 py-0.5 rounded">Brand</span>
<span class="bg-neutral-primary-soft text-heading text-xs font-medium px-1.5 py-0.5 rounded">Alternative</span>
<span class="bg-neutral-secondary-medium text-heading text-xs font-medium px-1.5 py-0.5 rounded">Gray</span>
<span class="bg-danger-soft text-fg-danger-strong text-xs font-medium px-1.5 py-0.5 rounded">Danger</span>
<span class="bg-success-soft text-fg-success-strong text-xs font-medium px-1.5 py-0.5 rounded">Success</span>
<span class="bg-warning-soft text-fg-warning text-xs font-medium px-1.5 py-0.5 rounded">Warning</span>
 -->