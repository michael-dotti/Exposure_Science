<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ResearchArea;
use App\Enums\EventType;

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::with('creator')->latest()->paginate(5);
        return view('events-management.index', compact('events'));
    }

    public function create()
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('events-management.create', compact('users','types'));
    }

    public function show(Event $event){
        $events = Event::with('creator')->latest()->paginate(1);
        return view('events-management.show', compact('event','events'));
    }

    public function store(Event $event)
    {
        
        request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'type' => ['required'],
            'users' => ['required', 'array', 'min:1'],
            'documents.*' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,webp,png,pptx,ppt,zip,rar,txt,xls,xlsx','max:51200'],
        ]);
        
        $event = Event::create([
            'title' => request()->title,
            'content' => request('content'),
            'type' => request()->type,
            'creator_user_id' => Auth::id(),
        ]);

        $event->recipients()->attach(request()->users);
        if(request()->hasFile('documents')) {
            foreach(request()->file('documents') as $file) {

                $path = $file->store('uploads/event/documents','public');

               
                $event->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }

        return redirect('/events-management');
    }

    public function edit(Event $event)
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('events-management.edit', compact('event','users','types'));
    }

    public function update(Event $event)
    {
        dd('TODO update');
    }

    public function destroy(Event $event)
    {
       dd('TODO destroy');
    }
}