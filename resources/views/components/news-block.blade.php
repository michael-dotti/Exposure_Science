@props(['n'])

<div class="bg-[#253041]/80 border border-gray-500 rounded-lg p-3 flex-1 gap-2 transition hover:-translate-y-1 w-lg h-lg ">
	<a href="/news/{{ $n->id }}" class="font-bold text-sm hover:text-blue-400 transition"> 
		{{ $n->title }}
		
		<div class="h-24 overflow-hidden rounded">
			<img src="{{ Storage::url($n->imagePath) }}" alt="news_image" class="w-full h-full object-cover">
		</div>

		<p class="text-xs text-gray-300">
			<span class="text-orange-400 font-semibold">{{ $n->publicationDate }}</span>
			{{ Str::limit($n->content, 60) }}
        </p>
    </a>
</div>