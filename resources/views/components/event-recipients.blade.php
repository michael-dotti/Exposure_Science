@props(['name' => 'recipients','users'])
<div>
    <div class="flex items-center justify-between mb-2">
        <x-label :required="true" :name="$name">Destinatari</x-label>
        <!-- Pulsante opzionale per selezionare tutti gli utenti-->
        <button type="button" 
                onclick="toggleRecipients(this)" 
                data-state="unselected"
                class="text-xs text-blue-400 hover:text-blue-300 focus:outline-none underline">
            Seleziona tutti
        </button>
    </div>

    <!-- Contenitore con scrollbar -->
    <div class="max-h-48 overflow-y-auto bg-neutral-secondary-medium border border-default-medium rounded-lg shadow-xs custom-scrollbar">
        <ul class="p-3 space-y-1 text-sm text-gray-200">
            @forelse($users as $user)
                <li>
                    <div class="flex items-center p-2 rounded-md hover:bg-white/5 transition-colors">
                        <input id="user-{{ $user->id }}" 
                               type="checkbox" 
                               value="{{ $user->id }}" 
                               name="{{ $name }}[]"
                               class="recipient-checkbox w-4 h-4 text-brand bg-mist-800 border-gray-600 rounded focus:ring-brand focus:ring-2 cursor-pointer">
                        <label for="user-{{ $user->id }}" class="w-full ms-3 flex flex-col cursor-pointer">
                            <span class="font-medium">{{ $user->name }} {{ $user->surname }}</span>
                            <span class="text-xs text-gray-400">{{ $user->email }}</span>
                        </label>
                    </div>
                </li>
            @empty
                <li>
                    <span class="text-sm text-gray-400 italic p-2">Nessun ricercatore trovato.</span>
                </li>
            @endforelse
        </ul>
    </div>
    <x-form-error name="$name" />
</div>


@pushOnce('scripts')
    @vite('resources/js/components/event-recipients.js')  
@endPushOnce