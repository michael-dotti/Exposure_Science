<x-layout-private>
	<x-slot:title>
		Ciao {{ $user->name . "!" }}
	</x-slot:title>
	<x-user-private-show :isPersonal="true" :user="$user" :showButtons="true" />
</x-layout-private>