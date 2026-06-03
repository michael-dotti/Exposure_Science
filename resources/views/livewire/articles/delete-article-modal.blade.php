<div>
    <button wire:click="$set('confirmingDeletion', true)" 
        wire:loading.attr="disabled"
        class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:cursor-pointer" type="button">
        Elimina
    </button>
                        
    <x-confirmation-modal wire:model.live="confirmingDeletion">
        <x-slot name="title">
            <p>ATTENZIONE!</p>
        </x-slot>
        <x-slot name="content">
            <p>Sei sicuro di eliminare l'articolo: {{ $article->title }}?</p>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('confirmingDeletion', false)" class="text-xs bg-yellow-500 text-white px-2 py-1 rounded hover:cursor-pointer">
                Annulla
            </button>
            
            <x-danger-button wire:click="deleteArticle"
                wire:loading.attr="disabled"
                >
                Elimina Definitivamente
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>