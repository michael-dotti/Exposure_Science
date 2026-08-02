<x-layout-private>
	<x-slot:title>
		Nuovo Progetto
	</x-slot:title>
 
	
	<x-form-layout action="{{ route('admin.projects.store') }}" method="POST" :has-files="true">
	
		<x-slot:header>
			<div class="flex justify-between items-center w-full my-5">
			<div>
				<h1 class="text-base/7 font-semibold text-white">Nuovo progetto</h1>
				<p class="text-xs text-gray-400 mt-1">I campi contrassegnati con <span class="text-red-500">*</span> sono obbligatori</p>
			</div>

			<div>
				<x-link-button href="{{ route('admin.projects.index') }}">back</x-link-button>
			</div>
			</div>
		</x-slot:header>

		<div>
			<x-input-text name="title" :required="true" label="Titolo"></x-input-text>
		</div>

		<div>
			<x-input-text name="status" :required="true" label="Stato"></x-input-text>
		</div>

		<div>
			<x-input-text name="funding_agency" label="Finanziatore"></x-input-text>
		</div>

		<div>
			<x-label :required="true">
				Descrizione
			</x-label>
			<x-textarea-quill name="description" />
		</div>

		<div>
			<x-label>
				Periodo
			</x-label>

			<div class="relative max-w-max">
				<input type="date" name="start_date" id="start_date" class="rounded-md w-full
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6">
			</div>

			<div class="relative max-w-max">
				<input type="date" name="end_date" id="end_date" class="rounded-md w-full
					border-0 bg-white/5 px-3 py-1.5 text-white shadow-sm
					ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 
					sm:text-sm/6">
			</div>
		</div>
	
	
	<x-slot:buttons>
		<a href="{{ route('admin.projects.index') }}">
		<x-danger-button type="button">Annulla</x-danger-button>
		</a>
		<x-save-button type="submit">Salva</x-save-button>
	</x-slot:buttons>

	</x-form-layout>

</x-layout-private>