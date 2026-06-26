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
    public function index(){
        //mostro nella home le tre notizie più nuove
        $user = Auth::user();

        $events = DB::table('events')->where('creator_user_id', $user->id)->latest()->simplePaginate(5);

        //dd($events);

        //$event = event::find(1);
        //$users = $event->users;
        //dd($users);
        //return view('publicationsPage.index', compact('articles'));
        return view('events-management.index', ['events' => $events]);
    }

    public function create()
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('events-management.create', compact('users','types'));
    }

    public function store(Event $event)
    {
        
        request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'type' => ['required'],
            'users' => ['required', 'array', 'min:1'],
            'documents.*' => ['nullable','file','mimes:pdf,doc,docx,jpg,png','max:5120'],
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

               
                $event->documents()->create([
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
}