<x-layout-menu-bar-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-email-box :events="$events" :event="$event"> 
        <div class="flex items-center space-x-3 pb-2 mb-4 border-b-2">
            <x-event-types-badges type="{{ $event->type }}"/>
            <h4 class="text-lg text-gray-800 font-bold"> 
                {{ $event->title }} 
            </h4>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-profile-foto-mini src="{{ $event->creator->profilePhotoUrl }}" alt="{{ $event->creator->name }}" class="border border-gray-500"/>
                <div class="flex flex-col ml-2">
                    <span class="text-sm font-semibold">{{ $event->creator->name}} {{ $event->creator->surname}}</span>
                    <span class="text-xs text-gray-400">From: {{ $event->creator->email }} </span>
                </div>
            </div>
            <span class="text-sm text-gray-500">{{$event->created_at->format('M d, Y, h:i A')}}</span>
        </div>

        <div class="py-6 pl-2 text-gray-700">
            {!! $event->content !!}
        </div>

        {{-- file condivisi --}}
        @if($event->attachments->isNotEmpty())
            <x-attachment-list :files="$event->attachments"/>
        @endif
    </x-email-box>
</x-layout-menu-bar-private>