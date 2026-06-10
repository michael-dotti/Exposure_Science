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
        $users = User::all();
        $types = EventType::cases();
        return view('events-management.create', compact('users','types'));
    }

    public function store(Event $event)
    {
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'type' => ['required'],
            'users' => ['required', 'array', 'min:1'],
        ]);
        
        $event = Event::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'creator_user_id' => Auth::id(),
        ]);

        $event->users_related_to_this_event()->attach(request()->users);

        return redirect('/events-management');
    }
}