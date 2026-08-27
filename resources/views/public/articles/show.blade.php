<x-layout-public>
	<x-slot:title>
		{{ $article->title }}
	</x-slot:title>
	<x-slot:heading>
		<div class="text-white text-3xl"> {{ $article->title }} </div>
		<pre class="text-white text-sm">{{ $article->researchAreas->pluck('name')->join(', ') }}</pre>
		<pre class="text-white text-sm">di @foreach($article->users as $user){{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif @endforeach
		</pre>
	</x-slot:heading>

	<!-- bottone per tornare all'index degli articoli -->
	<div class="mb-3">
		<x-public-botton-back title="Torna agli articoli" />
	</div>

	<!-- corpo dello show -->
	<div>
		<!-- div dell'astratto e immagine -->
		<div class="items-center justify-center bg-gray-900">
			<!-- grigliamento per avere astratto a sx e immagine a dx -->
			<div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10 md:px-10">
				<!-- astratto -->
				<div class="">
					<h1 class="mb-1 font-bold text-gray-300 italic">Astratto:</h1>
					<p class="mb-4 ml-6 font-medium text-white">{!! $article->abstract !!}</p>
				</div>

				<!-- immagine, la classe data serve per centrare la img nella colonna della griglia -->
				<div class="flex items-start justify-center">
					<img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="md:size-96 size-72 bg-gray-800 p-3" />
				</div>
			</div>
		</div>

		<!-- div dell'ottenimento dell'articolo -->
		<div class="grid grid-cols-2 mt-4">
			<!-- uso il componente box info, come in show di user -->
			<x-box-info>
				<x-slot:title>
					OTTIENI L'ARTICOLO
				</x-slot>
				<!-- check per mostrare il file da scaricare o il link per comprare l'articolo -->
				@if($article->document)
					<x-button-download-file :file="$article->document" text="Scarica l'articolo scientifico:"/>
				@else
					<p class="mb-6 text-white">Leggi l'articolo intero a:</p>
						<a class="text-cyan-400
						transition duration-200
						hover:text-cyan-600" href="{{ $article->external_url }}"> 
							{{ $article->external_url }}
						</a>
				@endif
			</x-box-info>
		</div>
	</div>

	
</x-layout-public>