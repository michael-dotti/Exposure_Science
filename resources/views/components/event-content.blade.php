@props(['event','showRecipients' => false])
<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 pb-3 mb-4 border-b-2 border-white/10">
    <div class="shrink-0">
        <x-event-types-badges type="{{ $event->type }}"/>
    </div>
    <h4 class="text-lg text-gray-200 font-bold wrap-break-word min-w-0"> 
        {{ $event->title }} 
    </h4>
</div>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div class="flex items-center min-w-0">
        <x-profile-foto-mini src="{{ $event->creator->profilePhotoUrl }}" alt="{{ $event->creator->name }}" class="border border-gray-500 shrink-0"/>
        <div class="flex flex-col ml-3 min-w-0">
            <span class="text-sm text-gray-100 font-semibold">{{ $event->creator->name}} {{ $event->creator->surname}}</span>
            <span class="text-xs text-gray-400">From: {{ $event->creator->email }} </span>
            @if ($showRecipients && $event->recipients && $event->recipients->isNotEmpty()) 
            {{-- Mostra i destinatari dell'evento solo se: è concesso all'utente di vederli (indicato dal props $showRecipients che
            è reso True solo dentro a admin.events-management.show) + se ci sono destinatari ) --}}
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-gray-400 shrink-0">To:</span>
                    
                    {{-- Stack di Avatar (massimo 4) --}}
                    <div class="flex items-center space-x-2 overflow-hidden">
                        @foreach($event->recipients->take(4) as $recipient)
                            <span class="text-xs text-gray-400 shrink-0">
                                {{ $recipient->name }} {{ $recipient->surname }}@if(!$loop->last), @endif
                            </span>
                        @endforeach
                    </div>
                    
                    {{-- Pulsante per aprire il Modale --}}
                    <button data-modal-target="recipientsModal" data-modal-toggle="recipientsModal" type="button" class="text-2xs bg-gray-700 hover:bg-gray-600 text-gray-200 hover:text-white font-medium px-2 py-0.5 rounded-full shrink-0 transition-colors">
                        @if($event->recipients->count() > 4)
                            +{{ $event->recipients->count() - 4 }} altri
                        @else
                            Vedi tutti
                        @endif
                    </button>
                </div>
            @endif
        </div>
    </div>
    <span class="text-sm text-gray-400 shrink-0 sm:text-right">{{$event->created_at->format('M d, Y, h:i A')}}</span>
</div>

<div class="py-6 pl-2 text-gray-200 text-sm sm:text-base wrap-break-word">
    {!! $event->content !!}
</div>

{{-- file condivisi --}}
@if($event->attachments->isNotEmpty())
    <x-attachment-list :files="$event->attachments"/>
@endif