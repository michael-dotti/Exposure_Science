@props([
    'events',
    'bulkDeleteRoute',
    'showRoute',
    'table_title'=>'Ultime Comunicazioni Ricevute' // per settare questo prop a "null", quando richiami il componente devi inserirgli una stringa vuota ''
])
<div class="flex flex-col flex-1 w-full min-h-[calc(100vh-3.5rem)]">
        
        <div class="w-full flex flex-col flex-1 min-h-0 p-4 sm:p-6">
            
            <div class="relative flex flex-col flex-1  shadow-md bg-slate-800 rounded-xl border border-slate-700/50 overflow-hidden">
                
                <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4 shrink-0">
                    @if($table_title)
                        <div class="flex items-center flex-1 space-x-4">
                            <h5 class="text-white">{{ $table_title }}</h5>
                        </div>
                    @endif
                    <div class="flex flex-col items-start space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        {{ $buttons }}
                    </div>
                </div>

                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full table-auto text-sm text-left text-gray-400">
                        <thead class="text-xs  uppercase bg-slate-900/60 text-gray-400 border-b border-slate-700/50">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-14">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only" >checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3 w-36 sm:w-44">Mittente</th>
                                <th scope="col" class="px-4 py-3 w-20 hidden md:table-cell lg:w-28">Tipo di Evento</th>
                                <th scope="col" class="px-4 py-3 w-80">Titolo</th>
                                <th scope="col" class="px-4 py-3 w-28 hidden lg:table-cell">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $events as $event )
                            {{-- onclick="window.location='URL'"== una volta cliccato sull'elemento spostati sulla pagina con url URL --}}
                                <tr onclick="window.location='{{ route($showRoute, $event->id) }}'" class="cursor-pointer border-b  border-slate-700/50  hover:bg-slate-700/50 transition-colors duration-150">
                                    <td class="px-4 py-3 w-14">
                                        <div class="flex items-center">
                                            <input name="event_ids[]" form="bulk-delete-form" value="{{ $event->id }}" type="checkbox" onclick="event.stopPropagation()" class="event-checkbox w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-gray-600">
                                            <label class="sr-only" >checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-4 py-2 font-medium whitespace-nowrap text-white">
                                        <div class="flex items-center min-w-0">
                                            <x-profile-foto-mini src="{{ $event->creator->profilePhotoUrl }}" class="mr-1"/>
                                            <span class="truncate text-sm font-semibold">
                                                {{ $event->creator->name }} {{ $event->creator->surname }}
                                            </span>
                                        </div>
                                    </th>
                                    <td class="px-4 py-2 w-20 hidden md:table-cell lg:w-28 align-middle">
                                       <x-event-types-badge type="{{ $event->type }}"/>
                                    </td>
                                    <td class="px-4 py-2 font-medium  text-white align-middle">
                                        <div class="line-clamp-2 break-all text-sm leading-snug max-w-80">
                                            {{ $event->title}}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium  whitespace-nowrap text-white hidden lg:table-cell w-28 align-middle">
                                        {{ $event->created_at->format('M d, Y') }}
                                    </td>
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