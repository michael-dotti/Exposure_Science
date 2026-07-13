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

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::with('creator')->latest()->paginate(5);
        return view('admin.events-management.index', compact('events'));
    }

    public function create()
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('admin.events-management.create', compact('users','types'));
    }

    public function show(Event $event){
        $events = Event::with('creator')->latest()->paginate(1);
        return view('admin.events-management.show', compact('event','events'));
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

        return redirect('/admin/events-management');
    }

    public function edit(Event $event)
    {
        $users = User::select('id', 'name','profile_photo_path')->get();
        $types = EventType::cases();
        return view('admin.events-management.edit', compact('event','users','types'));
    }

    public function update(Event $event)
    {
        dd('TODO update');
    }


    public function destroy(Event $event)
    {
    // 1) il gestore degli eventi ha eliminato l'evento nella sua visualizzazione
       /* $event->creator_user_id = null;
       $event->creator()->detach */
       
    }

    //TODO
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
        return redirect('/admin/events/index');
    }
}