<x-layout-private>
	<x-slot:title>
		Nuovo Progetto
	</x-slot:title>
 
	
	<x-form-layout action="{{ route('admin.projects.store') }}" method="POST" :has-files="true">
	
		<x-slot:header>
			<h1 class="text-base/7 font-semibold text-white">Nuovo progetto</h1>
		</x-slot:header>

		<x-content-section>
			<div class="space-y-5">
				<x-input-text name="title" :required="true" label="Titolo" />
	
				<x-textarea-quill name="description" label="Descrizione" :required="true" />
			</div>
		</x-content-section>

		<x-content-section>
			<div class="space-y-5">
				<div>
					<x-label name="status" :required="True">Stato</x-label>
					<select class="bg-white/5 p-2 pr-8 rounded-md border border-white/10 w-max"
						name="status" id="status">
						@foreach($statuses as $status)
							<option id="status-{{ $status->label() }}" name="statuses[]" value="{{ $status }}"
								class="w-max">
									{{ $status->label() }}
							</option>
						@endforeach
						<x-form-error name="users" />
					</select>
				</div>
		
				<x-input-text name="funding_agency" label="Finanziatore" />
			</div>
		</x-content-section>

		<x-content-section>
			<x-label name="users" :required="True">Autori (minimo 1)</x-label>
			<div class="grid grid-rows-4 grid-flow-col gap-x-12 gap-y-3 bg-white/5 p-6 rounded-md border border-white/10 overflow-x-auto">
				@foreach($users as $user)
					<div class="peer flex items-center gap-x-3 pr-4"> 
						<input id="user-{{ $user->id }}" name="users[]" value="{{ $user->id }}" type="checkbox" 
						class="h-4 w-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-600 bg-transparent"
						@checked($user->id == auth()->user()->id)>

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

			<div class="flex gap-4 items-center">
				<span>da</span>
				<input type="date" name="start_date" id="start_date" class="rounded-md w-fit
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6">
					
				<span>a</span>
				<input type="date" name="end_date" id="end_date" class="rounded-md w-fit
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6">
			</div>
			<x-form-error name="start_date" />
			<x-form-error name="end_date" />
		</x-content-section>

	
	<x-slot:buttons>
		<x-save-button type="submit">Salva</x-save-button>
		<a href="{{ route('admin.projects.index') }}">
			<x-danger-button type="button">Annulla</x-danger-button>
		</a>
	</x-slot:buttons>

	</x-form-layout>

</x-layout-private>