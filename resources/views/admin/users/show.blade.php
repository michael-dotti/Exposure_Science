<x-layout-private>
	<x-slot:title>
		Ciao {{ $user->name . "!" }}
	</x-slot:title>
	<x-user-private-show :isPersonal="true" :user="$user" />
</x-layout-private>