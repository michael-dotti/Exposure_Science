<x-layout-private>
	<x-slot:title>
		Ciao {{ $user->name . "!" }}
	</x-slot:title>
	<x-form-layout action="#" :hasFiles="True"> {{-- usato il componente form solo per sfruttarne la struttura --}}
		<x-slot:header>
			<h1 class="text-base/7 font-bold text-white">Qui puoi trovare le tue informazioni personali</h2>
		</x-slot:header>
		
		<div>
			<p class="text-base/7 font-bold text-white">Il tuo nominativo: </p>
				<p class="text-base/7 text-white ml-8"> {{ $user->name }} {{ $user->surname }} </p>
			<p class="text-base/7 font-bold text-white">La tua e-mail: </p>
				<p class="text-base/7 text-white ml-8"> {{ $user->email }} </p>
			<p class="text-base/7 font-bold text-white">La tua bio: </p>
				<p class="text-base/7 text-white ml-8"> {{ $user->bio }} </p>
			<p class="text-base/7 font-bold text-white mt-2">Il tuo sito web: </p>
				@if ($user->website)	
					<a
							class="text-cyan-400
							transition duration-200
							hover:text-cyan-600
							ml-8"
							href="{{ $user->website }}"
						> {{ $user->website }} </a>
				@else
					<p class="text-base/7 text-gray-500 ml-8 italic"> [non hai inserito nessun sito a tuo nome] </p>
				@endif
		</div>


		<div>
			<p class="text-base/7 font-bold text-white mt-2">La tua immagine profilo: </p>
			<img src="{{ $user->profilePhotoUrl }}" alt="profile_photo" class="rounded-full w-32 h-32 object-cover ml-8">
		</div>
		
		<x-slot:buttons>
			<div class="my-4 flex items-center justify-end gap-3">
				<a href="/admin/users/edit">
					<x-save-button type="button" >MODIFICA DATI</x-danger-button>
				</a>
			</div>
		</x-slot:buttons>
		
	</x-form-layout>
</x-layout-private>