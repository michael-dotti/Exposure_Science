<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use illuminate\support\Facades\Auth;

class EventController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $events = $user->events_to_do()->with('creator')->simplePaginate(5);
 
         return view('events.index', [
            'events'=> $events
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
        return view('events.show', ['event'=> $event ]);
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
       
    }
}
