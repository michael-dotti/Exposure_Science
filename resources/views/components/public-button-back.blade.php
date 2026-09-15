@props([
	'title',
	'icon' => 'fa-solid fa-arrow-left',
	'href' => 'url()->previous()'
])
<a href="{{ $href }}"
	class="inline-flex items-center px-4 py-2 
			transition rounded-md bg-amber-300
			hover:bg-amber-200"
>
	<p class="text-md font-semibold text-slate-900">
		<i class="{{ $icon }}"></i> {{ $title }}
	</p> 
</a>
