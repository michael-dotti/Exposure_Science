<x-layout-private>
	<x-slot:title>
		Ciao {{ $user->name . "!" }}
	</x-slot:title>
	<x-user-show :user="$user" :showButtons="true" />
</x-layout-private>