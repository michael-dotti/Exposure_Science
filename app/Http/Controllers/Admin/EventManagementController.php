<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo importare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ResearchArea;
use App\Enums\EventType;
use Mews\Purifier\Facades\Purifier;
use App\Traits\EventPaginationTrait;

class EventManagementController extends Controller
{
    use EventPaginationTrait;

    public function index(Request $request)
    {
        $events = Event::with('creator')
        ->filterByType($request->query('type'))
        ->latest() // ordina gli eventi in base alla colonna: events.created_at
        ->paginate(10)
        ->withQueryString(); // Mantiene i parametri nell'URL cosi da non perdere il filtraggio mentre ti sposti tra le pagine della paginazione

        
        $types = EventType::cases();
        return view('admin.events-management.index', compact('events','types'));
    }

    public function create()
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('admin.events-management.create', compact('users','types'));
    }

    public function show(Event $event)
    {
        // 1) Carico le relazioni in anticipo
        $event->load(['creator', 'recipients', 'attachments']);

        // 2) Recupero gli ID di tutti gli eventi ordinati dal più recente:
        $allIds = Event::orderBy('created_at', 'desc')->orderBy('id','desc')->pluck('id');

       // 3. Usa la funzione del Trait per calcolare i dati che mi servono per la paginazione
        $paginationData = $this->calculateCustomPagination($allIds, $event->id);

        // 4. Passa i dati alla vista
        return view('admin.events-management.show', array_merge(['event' => $event], $paginationData));
        /* Spiegazione:
        - array_merge() = unsicre gli array in uno solo
        - laravel chiama la funzione php extract() Prende un array associativo e trasforma ogni chiave in una vera e propria variabile, assegnandole il valore corrispondente
        */
    }

    public function store()
    {
        $validated = request()->validate([
            'title'         => ['required','min:3','max:255'],
            'content'       => ['required','max:5000'],
            'type'          => ['required'],
            'recipients'    => ['required', 'array', 'min:1'], // l'array degli user destinatari
            'recipients.*'  => ['exists:users,id'], // Verifico che ogni ID inviato esista davvero
            'attachments'   => ['nullable', 'array'],
            'attachments.*' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,webp,png,pptx,ppt,zip,rar,txt,xls,xlsx','max:51200'],
        ]);

        $content_cleaned = Purifier::clean($validated['content']);

        // 2. Transazione Database per garantire l'integrità dei dati
        DB::transaction(function () use ($content_cleaned) {
            $event = Event::create([
                'title' => request()->title,
                'content' => $content_cleaned,
                'type' => request()->type,
                'creator_user_id' => Auth::id(),
            ]);

            $event->recipients()->attach(request()->recipients);
            
            if(request()->hasFile('attachments')) {
                foreach(request()->file('attachments') as $file) {

                    $path = $file->store('uploads/event/attachments','public');

                    $event->attachments()->create([
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(), // recupera il Mime Type reale del file
                        'file_size' => $file->getSize() // recuperal adimensione esatta in byte
                    ]);
                }
            }
        });
        
        return redirect()->route('admin.events-management.index')->with(
                'success',
                'Evento creato correttamente.'
            );
    }


     // l'admin, o il gestore degli eventi, decide che l'evento è da eliminare
    public function destroy(Event $event)
    {
        // 1) elimino l'evento
        $event->delete();

        // 2) Cerchiamo il prossimo evento rimasto nel sistema (escludendo quello appena cancellato)
        $nextEvent = Event::where('id', '!=', $event->id)
            ->orderBy('created_at', 'desc') // Mantieni lo stesso ordinamento della tua index admin
            ->first();

        // 3) Se c'è un altro evento, reindirizza alla sua schermata show di gestione
        if ($nextEvent) {
            return redirect()->route('admin.events-management.show', $nextEvent);
        }
        else {
             // 4) Altrimenti, se non ci sono più eventi nel sistema, torna alla index di gestione
            return redirect()->route('admin.events-management.index')->with(
                'success',
                'Evento eliminato correttamente.'
            );
        }

    }

    
    // distrugge gli eventi selezionati 
    public function bulkDelete(Request $request)
    {
        // 1) Validazione
        $validated = request()->validate([
            'event_ids' => ['required','array'],
            'event_ids.*' => ['exists:events,id'] // il simbolo ".*" prende tutti gli elementi dell'array 
            // exists:event,id == verifica nella tabella "events" la colonna "id" (regola fondamentale per le cancellazioni di massa)
        ]);

        // 2) Recupero tutti gli eventi selezioanti dal database
        $events = Event::whereIn('id', $request->event_ids)->get();

        // 3) Elimino "fisicamente" ogni evento
        foreach($events as $event) 
        {
            $event->delete();
        }
        
        // 5) Redirect
        return $this->redirectBackOrTo('admin.events-management.index')->with(
                'success',
                'Eventi eliminati correttamente.'
            );
    }
}