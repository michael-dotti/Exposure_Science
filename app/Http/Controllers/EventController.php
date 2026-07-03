<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use illuminate\support\Facades\Auth;
use App\Enums\EventType;

class EventController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index(Request $request) // il request prende i parametri passati nell'url, esempio /events?type=task
    {
        
        $user = Auth::user();

        $events = $user->events_receives()
            ->with('creator')
            ->filterByType($request->query('type')) // filtro per tipo di evento se presente nel request (Nota: $request->query('type) restitusice null se non c'è request)
            ->latest()
            ->Paginate(10);

        return view('events.index', [
            'events' => $events,
            'types' => EventType::cases(),
        ]);
    }

    // create = porta alla view di creazione di un articolo
    public function create()
    {  
        $users = User::select('id', 'name')->get();
        return view('events-management.create', compact('users'));
    }

    //Show= porta alla view per vedere un singolo articolo
    public function show(Event $event)
    {
        $user = Auth::user();
        $events = $user->events_receives()->with('creator')->latest()->Paginate(1);
       
        return view('events.show', compact('event','events'));
    }

    // store = esegue l'autenticazione e poi aggiunge un articolo
    public function store()
    {
       
    }

    // edit =porta alla pagina di modifica articolo
    public function edit(Event $event)
    {
        $users = User::select('id', 'name')->get();
        return view('events-management.edit', compact('event','users'));
    }

    // update = verifica e aggiorna un articolo
    public function update(Event $event)
    {
        
    }

    // destroy = distrugge un articolo
    public function destroy(Event $event)
    {
        $user = Auth::user();
        $user->events_receives()->detach($event);

        $events = $user->events_receives()->with('creator')->latest()->Paginate(10);

        return view('events.index', [
            'events' => $events,
            'types' => EventType::cases(),
        ]);
    }

    public function bulkDelete(Request $request)
    {

        $validated = request()->validate([
            'event_ids' => ['required','array'],
            'event_ids.*' => ['exists:events,id'] // il simbolo ".*" prende tutti gli elementi dell'array 
            // exists:event,id == verifica nella tabella "events" la colonna "id" (regola fondamentale per le cancellazioni di massa)
        ]);

        $user = Auth::user();
        $user->events_receives()->detach($request->event_ids);
        
        $events = $user->events_receives()
            ->with('creator')
            ->filterByType($request->query('type')) // filtro per tipo di evento se presente nel request 
            ->latest()
            ->Paginate(10);

        return view('events.index',[
            'events' => $events,
            'types' => EventType::cases(),
        ]);
    }
}
