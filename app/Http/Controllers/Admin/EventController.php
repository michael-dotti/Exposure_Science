<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use illuminate\support\Facades\Auth;
use App\Enums\EventType;
use App\Traits\EventPaginationTrait;

class EventController extends Controller
{
    use EventPaginationTrait;

    public function index(Request $request) // il request prende i parametri passati nell'url, esempio /events?type=task
    {
        
        $user = Auth::user();

        $events = $user->events_receives()
            ->wherePivotNull('deleted_at') // se la colonna "deleted_at" della tabella pivot è null, allora significa che l'utente non ha "eliminato logicamente" l'evento e che quindi può visualizzarlo nelal sua schermata
            ->with('creator')
            ->filterByType($request->query('type')) // filtro per tipo di evento se presente nel request (Nota: $request->query('type) restitusice null se non c'è request)
            ->latest() // ordina gli eventi in base alla colonna: events.created_at
            ->Paginate(10)
            ->onEachSide(1)
            ->withQueryString(); // Mantiene i parametri nell'URL cosi da non perdere il filtraggio mentre ti sposti tra le pagine della paginazione

        return view('admin.events.index', [
            'events' => $events,
            'types' => EventType::cases(),
        ]);
    }

    public function show(Event $event)
    {
        $user = Auth::user();

        // 1. Controllo di sicurezza (l'utente può visualizzare questo evento?)
        $hasAccess = $user->events_receives()
            ->wherePivotNull('deleted_at')
            ->where('event_id', $event->id)
            ->exists();

        if (!$hasAccess) {
            abort(404); // Se lo ha eliminato o non è suo, errore 404
        }

        // 2. Carica le relazioni in anticipo
        $event->load(['creator', 'recipients', 'attachments']);

        // 3. Prendi tutti gli ID
        $allIds = $user->events_receives()
            ->wherePivotNull('deleted_at')
            ->orderBy('events.created_at', 'desc')
            ->orderBy('events.id', 'desc')
            ->pluck('events.id');

        // 4. Usa la funzione del Trait
        $paginationData = $this->calculateCustomPagination($allIds, $event->id);

        // 5. Passa i dati alla vista
        return view('admin.events.show', array_merge(['event' => $event], $paginationData));
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

        
        // 5) Cerchiamo il prossimo evento disponibile per questo utente
        $nextEvent = $user->events_receives()
            ->wherePivotNull('deleted_at') // Prendi solo quelli non eliminati
            ->where('events.id', '!=', $event->id) // Escludi quello appena cancellato
            ->orderBy('events.created_at', 'desc') // Usa lo stesso ordinamento della tua paginazione/index
            ->first();

        // 6) Redirect condizionale
        if ($nextEvent) {
            // Se c'è un altro evento, vai alla sua schermata di dettaglio (show)
            return redirect()->route('admin.events.show', $nextEvent);
        }
        else {
             // Altrimenti, se non ci sono più eventi, torna alla pagina index
            return redirect()->route('admin.events.index');
        }
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
               $query->whereNull('event_user.deleted_at'); // Cerca eventi senza destinatari attivi
            })
            ->get();

        // 4) Elimino definitivamente gli eventi orfani
        foreach($orphanedEvents as $event){
            $event->delete();
        }
        
        // 5) Redirect
        return $this->redirectBackOrTo('admin.events.index')->with(
                'success',
                'Eventi eliminati correttamente.'
            );
    }
}
