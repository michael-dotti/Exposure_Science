<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

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

        return view('admin.events.index', [
            'events' => $events,
            'types' => EventType::cases(),
        ]);
    }

    

    
    public function show(Event $event)
    {
        $user = Auth::user();
        $events = $user->events_receives()->with('creator')->latest()->Paginate(1);
       
        return view('admin.events.show', compact('event','events'));
    }

    
    public function destroy(Event $event)
    {
        // 1) prendo l'utente attualmente loggato
        $user = Auth::user();

        // 2) Rimuovo il legame che l'utente attuale ha con l'evento selezionato 
        $user->events_receives()->detach($event);

        // 3) verifico se ora l'evento è orfano
        $isOrphan = is_null($event->creator_user_id) && !$event->recipients()->exists();

        // 4) Se l'evento è orfano lo elimino
        if ($isOrphan){
            $event->delete();
        }

        // 5) redirect
        return redirect('/admin/events');
    }

    // distrugge gli eventi selezionati dall'utente loggato in admin.events.index, senza eliminare l'evento dal database, ma solo la relazione tra l'utente e l'evento (detach)
    public function bulkDelete(Request $request)
    {
        // 1) Validazione
        $validated = request()->validate([
            'event_ids' => ['required','array'],
            'event_ids.*' => ['exists:events,id'] // il simbolo ".*" prende tutti gli elementi dell'array 
            // exists:event,id == verifica nella tabella "events" la colonna "id" (regola fondamentale per le cancellazioni di massa)
        ]);

        $user = Auth::user();

        // 2) Rimuovo il legame che l'utente corrente ha con tutti gli eventi selezionati in un colpo solo
        $user->events_receives()->detach($request->event_ids);

        // 3) Trovo quali eventi sono appena diventati "Orfani" 
        // (Cioè creatore nullo E zero utenti collegati)
        $orphanedEvents = Event::whereIn('id', $request->event_ids) // interroga il database cercando tutti i record che corrispondo a quell'elenco di ID
            ->whereNull('creator_user_id') // il creatore non c'è più
            ->doesntHave('recipients') // non ci sono più destinatari epr quell'evento
            ->get();

        // 4) Elimino definitivamente gli eventi orfani
        foreach($orphanedEvents as $event) 
        {
            $event->delete();
        }
        
        // 5) Redirect
        return redirect('/admin/events');
    }
}
