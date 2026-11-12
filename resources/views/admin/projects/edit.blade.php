<x-layout-private>
	<x-slot:title>
		Modifica Progetto
	</x-slot:title>

	<!-- roba per il delet -->
	<form method="POST" action="{{ route('admin.projects.destroy', $project) }}" id="delete_form" class="hidden">
		@csrf
		@method('DELETE')
	</form>
	
	<!-- componente per il form -->
	<x-form-layout action="{{ route('admin.projects.update', $project) }}" method="PATCH">
	
		<!-- titolo -->
		<x-slot:header>
			<h1 class="text-base/7 font-semibold text-white">Modifica progetto</h1>
		</x-slot:header>

		<!-- modifica dati -->
		<x-content-section>
			<div>
				<x-input-text name="title" :required="true" label="Titolo" value="{{ $project->title }}"></x-input-text>
			</div>

			<div>
				<x-label :required="true">
					Descrizione
				</x-label>
			</div>

			<x-textarea-quill name="description" value="{!! $project->description !!}"/>
		</x-content-section>

		<x-content-section>
			<div class="space-y-5">
				
				<x-project-status-dropdown :statuses="$statuses" :selected="$project->status" />

				<x-input-text name="funding_agency" label="Finanziatore" value="{{ $project->funding_agency }}" />
			</div>
		</x-content-section>


		<x-content-section>
			<x-label name="users" :required="True">Collaboratori (minimo 1)</x-label>
			<div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
				@foreach($users as $user)
					<div class="flex items-center gap-x-3 pr-4"> 
						<input 
							id="user-{{ $user->id }}" 
							name="users[]" 
							value="{{ $user->id }}" 
							type="checkbox"
								@if(in_array($user->id, old('users', $project->users->pluck('id')->toArray()))) checked
								@endif
							class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent">

						<label for="user-{{ $user->id }}" class="text-sm text-white whitespace-nowrap">
							{{ $user->name }}
						</label>
					</div>
				@endforeach
				<x-form-error name="users" />
			</div> 
		</x-content-section>

		<x-content-section>
			<x-label>
				Periodo
			</x-label>
			
			<div class="space-y-2">
				<div class="flex gap-4 items-center">
					<span>da</span>
					<input type="date" name="start_date" id="start_date" class="rounded-md w-fit
						border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
						ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
						sm:text-sm/6"
						value="{{ old('start_date', $project->start_date ?? '') }}">
					<span>a</span>
					<input type="date" name="end_date" id="end_date" class="rounded-md w-fit
						border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
						ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
						sm:text-sm/6"
						value="{{ old('end_date', $project->end_date ?? '') }}">
					
				</div>

				<div class="flex flex-col gap-1">
					<x-form-error name="start_date" />
					<x-form-error name="end_date" />
				</div>
			</div>
		</x-content-section>
	
	
		<!-- pulsanti di elimina e salva -->
		<x-slot:buttons>
			<x-save-button type="submit" >Salva</x-save-button>
			<x-danger-button form="delete_form" >Elimina</x-danger-button>
		</x-slot:buttons>

	</x-form-layout>

</x-layout-private>