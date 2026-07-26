<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
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

class EventManagementController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('creator')
        ->filterByType($request->query('type'))
        ->latest() // ordina gli eventi in base alla colonna: events.created_at
        ->paginate(10);
        
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
        // 1) carico i destinatari (recipients) con i dati della pivot e gli allegati (attachments) per questo evento specifico
        $event->load(['recipients','attachments']);

        // 2) prendo tutti gli eventi, con il proprio creatore, per effettuare la paginazione "Precedente/Successivo"
        // gli è gestore degli eventi (e admin) vede tutti gli eventi
        $events = Event::with('creator')->latest()->paginate(1);
        return view('admin.events-management.show', compact('event','events'));
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
        DB::transaction(function () use ( $content_cleaned) {
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
                    ]);
                }
            }
        });
        
        return redirect()->route('admin.events-management.index');
    }


     // l'admin, o il gestore degli eventi, decide l'evento è da eliminare
    public function destroy(Event $event)
    {
        $event->delete();
       
        return redirect('/admin/events-management');
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
        return redirect('/admin/events-management');
    }
}