@props(['n','hrefShow'])

<div class="w-full h-full bg-[#253041]/80 border border-gray-500 rounded-lg p-3 gap-2 transition hover:-translate-y-1">
	<a href="{{ $hrefShow }}" class="font-bold text-sm hover:text-blue-400 transition"> 
		{{ $n->title }}
		
		<div class="h-24 overflow-hidden rounded">
			<img src="{{ Storage::url($n->image_path) }}" alt="news_image" class="w-full h-full object-cover">
		</div>

		<p class="text-xs text-gray-300">
			<span class="text-orange-400 font-semibold">{{ $n->created_at->format('Y-m-d') }}</span>
			{{ Str::limit($n->content, 60) }}
        </p>
    </a>
</div>