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
    public function index(Request $request) // il request prende i parametri passati nell'url, esempio /events?type=task
    {
        
        $user = Auth::user();

        $events = $user->events_receives()
            ->wherePivotNull('deleted_at') // <--- Filtra solo quelli attivi per l'utente
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
        // Verifica se l'evento è associato all'utente ed è ancora attivo
        $hasAccess = Auth::user()->events_receives()
        ->wherePivotNull('deleted_at') 
        ->where('event_id', $event->id)
        ->exists();

        if (!$hasAccess){
            abort(404); // Se lo ha eliminato o non è suo, l'evento per lui "non esiste"
        }

        $user = Auth::user();
        $events = $user->events_receives()  
            ->wherePivotNull('deleted_at') // verifica che l'evento esista per lui
            ->with('creator')
            ->latest()
            ->Paginate(1);
       
        return view('admin.events.show', compact('event','events'));
    }

    
    public function destroy(Event $event)
    {
        // 1) prendo l'utente attualmente loggato
        $user = Auth::user();

        // 2) Segna come eliminato solo per questo utente nella tabella pivot
        $user->events_receives()->updateExistingPivot($event->id, [
            'deleted_at' => now()
        ]);

        // 3) verifico se ora l'evento è orfano
        // Nota: ciò accade solo se i lcreatore delle'vento viene eliminato
        $isOrphan = is_null($event->creator_user_id) && !$event->recipients()->wherePivotNull('deleted_at')->exists();

        // 4) Se l'evento è orfano lo elimino
        if ($isOrphan){
            $event->delete();
        }

        // 5) redirect
        return redirect('/admin/events');
    }

    // distrugge (rimuove il legame e li elimina SE sono diventati orfani) gli eventi selezionati dall'utente loggato in admin.events.index, senza eliminare l'evento dal database, ma solo la relazione tra l'utente e l'evento (detach)
    public function bulkDelete(Request $request)
    {
        // 1) Validazione
        $validated = request()->validate([
            'event_ids' => ['required','array'],
            'event_ids.*' => ['exists:events,id'] // il simbolo ".*" prende tutti gli elementi dell'array 
            // exists:event,id == verifica nella tabella "events" la colonna "id" (regola fondamentale per le cancellazioni di massa)
        ]);

        $user = Auth::user();

        // 2) Cestina la pivot per tutti gli eventi selezionati
        foreach ($request->event_ids as $id) {
            $user->events_receives()->updateExistingPivot($id, [
                'deleted_at' => now()
            ]);
        }

        // 3) Trovo quali eventi sono appena diventati "Orfani" 
        // (Cioè creatore nullo E zero utenti collegati)
        $orphanedEvents = Event::whereIn('id', $request->event_ids)
            ->whereNull('creator_user_id')
            ->whereDoesntHave('recipients', function($query) {
                $query->wherePivotNull('deleted_at'); // Cerca eventi senza destinatari attivi
            })
            ->get();

        // 4) Elimino definitivamente gli eventi orfani
        foreach($orphanedEvents as $event){
            $event->delete();
        }
        
        // 5) Redirect
        return redirect('/admin/events');
    }
}
