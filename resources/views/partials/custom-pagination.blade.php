@if ($paginator->hasPages()) {{-- appare solo se ci sono un numero di eventi sufficienti per creare almeno due pagine --}}
    <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0 shrink-0 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Mostrati elementi da
            <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span>
            -
            <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span>
            di
            <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
        </span>

        <ul class="inline-flex items-stretch -space-x-px">
            
            {{-- Bottone Pagina Precedente --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-400 bg-gray-100 rounded-l-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                </li>
            @endif

            {{-- Elementi della Paginazione (Numeri e "...") --}}
            @foreach ($elements as $element)
                {{-- Separatore a tre punti "..." --}}
                @if (is_string($element))
                    <li class="hidden lg:block">
                        <span class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array di Link Numerici --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="hidden lg:block">
                                <span aria-current="page" class="z-10 flex items-center justify-center px-3 py-2 text-sm leading-tight border text-primary-600 bg-primary-50 border-primary-300 dark:bg-gray-700 dark:text-white font-semibold">{{ $page }}</span>
                            </li>
                        @else
                            <li class="hidden lg:block">
                                <a href="{{ $url }}" class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bottone Pagina Successiva --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-400 bg-gray-100 rounded-r-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif