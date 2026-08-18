<x-layout-public>
	<x-slot:title>
		{{ $user->name }} {{ $user->surname }}
	</x-slot:title>
	<x-slot:heading>
		{{ $user->name }} {{ $user->surname }}
	</x-slot:heading>

	<!-- bottone per tornare all'index del team -->
	<div class="mt-1">
		<a href="{{ route('public.users.index') }}"
			class="inline-flex items-center px-4 py-2 text-sm font-semibold
					text-slate-900 transition rounded-md bg-amber-300
					hover:bg-amber-200"
		>
			< Torna al team
		</a>
	</div>

	<!-- Contenitore principale centrato nella pagina -->
	<div class="max-w-5xl mx-auto w-full px-4 py-8 flex flex-col gap-8">
		
		<!-- Box del Profilo -->
		<div class="bg-gray-800 rounded-xl p-6 md:p-10 shadow-lg">
			<!-- grigliamento per avere ruolo e bio a sx e l'immagine a dx-->
			<div class="grid md:grid-cols-2 grid-cols-1 items-center gap-10">
				<!-- div di ruolo e bio -->
				<div class="shadow-xl/20 shadow-gray-800">
					<!-- ruolo -->
					<h1 class="mb-1 font-bold text-white">Ruolo</h1>
					<p class="mt-1 mb-6 ml-6 font-medium text-amber-400">
						<!-- check di che ruolo scrivere -->
						@if ($user->hasRole('admin'))
							Team Leader
						@elseif ($user->hasRole('teacher'))
							Docente
						@else
							Membro del Team
						@endif
					</p>
					<!-- bio -->
					<h1 class="mb-1 font-bold text-white">Descrizione</h1>
					<p class="mb-4 ml-6 font-medium text-gray-200">{{ $user->bio }}</p>
				</div>
				<!-- div dell'immagine, centrata all'interno della sua colonna -->
				<div class="flex justify-center">
					<img src="{{ $user->profilePhotoUrl }}" alt="{{ $user->name }}" class="md:size-50 size-50 rounded-full object-cover" />
				</div>
			</div>
		</div>

		<!-- grigliamento per avere i box informativi di contatti e curriculum uno di fianco all'altro -->
		<div class="grid grid-cols-2 gap-4">
			<!-- box per i contatti -->
			<x-box-info>
				<x-slot:title>
					CONTATTI
				</x-slot>
				<b> E-MAIL: </b> {{ $user->email }}
				
				<!-- check presenza website -->
				@if ($user->website)
					<br> <b> WEBSITE: </b> 
					<a
						class="text-cyan-400 transition duration-200 hover:text-cyan-600"
						href="{{ $user->website }}"
						target="_blank"
						rel="noopener noreferrer"
					>
						{{ $user->website }} 
					</a>
				@endif
			</x-box-info>

			<!-- check presenza curriculum -->
			@if ($user->curriculum)
				<!-- box per il curriculum -->
				<x-box-info>
					<x-slot:title>
						CURRICULUM VITAE
					</x-slot>
					<x-button-open-file :file="$user->curriculum" text="visualizza il curriculum di {{ $user->name }} {{ $user->surname }}" />
				</x-box-info>
			@endif
		</div>
		
	</div>
</x-layout-public>
