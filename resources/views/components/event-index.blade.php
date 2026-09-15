@props([
    'events',
    'bulkDeleteRoute',
    'showRoute',
    'table_title'=>'Ultime Comunicazioni Ricevute' // per settare questo prop a "null", quando richiami il componente devi inserirgli una stringa vuota ''
])
<div class="flex flex-col flex-1 w-full min-h-[calc(100vh-3.5rem)]">
        
        <div class="w-full flex flex-col flex-1 min-h-0 p-4 sm:p-6">
            
            <div class="relative flex flex-col flex-1 bg-white shadow-md dark:bg-slate-800 rounded-xl border border-transparent dark:border-slate-700/50 overflow-hidden">
                
                <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4 shrink-0">
                    @if($table_title)
                        <div class="flex items-center flex-1 space-x-4">
                            <h5 class="text-white">{{ $table_title }}</h5>
                        </div>
                    @endif
                    <div class="flex flex-col shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        {{ $buttons }}
                    </div>
                </div>

                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-900/60 dark:text-gray-400 border-b border-gray-200 dark:border-slate-700/50">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only" >checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">Mittente</th>
                                <th scope="col" class="px-4 py-3">Tipo di Evento</th>
                                <th scope="col" class="px-4 py-3">Titolo</th>
                                <th scope="col" class="px-4 py-3">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $events as $event )
                            {{-- onclick="window.location='URL'"== una volta cliccato sull'elemento spostati sulla pagina con url URL --}}
                                <tr onclick="window.location='{{ route($showRoute, $event->id) }}'" class="cursor-pointer border-b border-gray-100 dark:border-slate-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                                    <td class="w-4 px-4 py-3">
                                        <div class="flex items-center">
                                            <input name="event_ids[]" form="bulk-delete-form" value="{{ $event->id }}" type="checkbox" onclick="event.stopPropagation()" class="event-checkbox w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-gray-600">
                                            <label class="sr-only" >checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-profile-foto-mini src="{{ $event->creator->profilePhotoUrl }}" class="mr-1"/>
                                        {{ $event->creator->name }} {{ $event->creator->surname }}
                                    </th>
                                    <td class="px-4 py-2">
                                       <x-event-types-badge type="{{ $event->type }}"/>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            {{ $event->title}}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $event->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty 
                            {{-- Eseguito solo se $events è vuoto --}}
                            {{-- Senza tr e td il contenuto di <tbody> non appare correttamente --}}
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center">
                                        <x-message-of-empty title="Nessun Evento al Momento" image="fa-regular fa-envelope"></x-message-of-empty>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginazione --}}
                <div class="my-6 px-4">
                    {{ $events->links() }}
                </div>

            </div>
        </div>
    </div>
    <form id="bulk-delete-form" action="{{ route($bulkDeleteRoute) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
    @vite('resources/js/components/select-all-rows-table.js')  