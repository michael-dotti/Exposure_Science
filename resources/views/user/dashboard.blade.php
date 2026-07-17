<x-layout-menu-bar-private>
	<x-slot:title>
		Ciao {{ auth()->user()->name . "!" }}
	</x-slot:title>
	<x-form-layout method="PATCH" action="/dashboard/{{ auth()->user()->id}}" :hasFiles="True">
		<x-slot:header>
			<h1 class="text-base/7 font-bold text-white">Qui puoi trovare le tue informazioni personali</h2>
		</x-slot:header>
		
		<div>
			<p class="text-base/7 font-bold text-white mt-2">Il tuo nominativo: </p>
				<p class="text-base/7 text-white ml-8"> {{ auth()->user()->name }} {{ auth()->user()->surname }} </p>

			<p class="text-base/7 font-bold text-white mt-2">La tua e-mail: </p>
				<p class="text-base/7 text-white ml-8"> {{ auth()->user()->email }} </p>
			
			<p class="text-base/7 font-bold text-white mt-2">La tua bio: </p>
				<p class="text-base/7 text-white ml-8"> {{ auth()->user()->bio }} </p>
			
			<p class="text-base/7 font-bold text-white mt-2">Il tuo sito web: </p>
				@if (auth()->user()->website)	
					<a
							class="text-cyan-400
							transition duration-200
							hover:text-cyan-600
							ml-8"
							href="{{ auth()->user()->website }}"
						> {{ auth()->user()->website }} </a>
				@else
					<p class="text-base/7 text-gray-500 ml-8 italic"> [non hai inserito nessun sito a tuo nome] </p>
				@endif
		</div>


		<div>
			<p class="text-base/7 font-bold text-white  mt-2">La tua immagine profilo: </p>
			<img src="{{ auth()->user()->profilePhotoUrl }}" alt="profile_photo" class="rounded-full w-32 h-32 object-cover ml-8">
		</div>
		
		<x-slot:buttons>
			<div class="my-4 flex items-center justify-end gap-3">
					<a href="/dashboard/edit">
						<x-save-button type="button" >MODIFICA DATI</x-danger-button>
					</a>
			</div>
		</x-slot:buttons>
		
	</x-form-layout>
</x-layout-menu-bar-private>