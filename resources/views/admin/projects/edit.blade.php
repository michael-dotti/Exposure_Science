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
			<p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
		</x-slot:header>

		<!-- modifica dati -->
		<x-content-box>
			<div>
				<x-input-text name="title" :required="true" label="Titolo" value="{{ $project->title }}"></x-input-text>
			</div>

			<div>
				<x-label :required="true">
					Descrizione
				</x-label>
			</div>

			<x-textarea-quill name="description" value="{!! $project->description !!}"/>
		</x-content-box>

		<x-content-box>
			<x-label name="status" :required="True">Stato</x-label>
			<select class="bg-white/5 p-2 pr-8 rounded-md border border-white/10 w-max"
				name="status" id="status">
				@foreach($statuses as $status)
					<option id="status-{{ $status->label() }}" name="statuses[]" value="{{ $status }}"
						class="w-max"
						@if($status == $project->status)
							selected="selected"
						@endif>
							{{ $status->label() }}
					</option>
				@endforeach
				<x-form-error name="users" />
			</select>
		</x-content-box>

		<x-content-box>
			<x-input-text name="funding_agency" label="Finanziatore" value="{{ $project->funding_agency }}"></x-input-text>
		</x-content-box>

		<x-content-box>
			<x-label name="users" :required="True">Autori (minimo 1)</x-label>
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
		</x-content-box>

		<x-content-box>
			<x-label>
				Periodo
			</x-label>

			<div class="flex gap-4 items-center">
				<span>da</span>
				<input type="date" name="start_date" id="start_date" class="rounded-md w-fit
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6"
					value="{{ $project->start_date }}">
				<span>a</span>
				<input type="date" name="end_date" id="end_date" class="rounded-md w-fit
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6"
					value="{{ $project->end_date }}">
			</div>
		</x-content-box>
	
	
		<!-- pulsanti di elimina e salva -->
		<x-slot:buttons>
			<x-save-button type="submit" >Salva</x-save-button>
			<x-danger-button form="delete_form" >Elimina</x-danger-button>
		</x-slot:buttons>

	</x-form-layout>

</x-layout-private>