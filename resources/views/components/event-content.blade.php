@props(['event'])
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