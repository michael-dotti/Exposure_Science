<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Article;
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

        $events = DB::table('events')->where('creator_user_id', $user->id)->get();

        //dd($events);

        //$article = Article::find(1);
        //$users = $article->users;
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

    public function store()
    {
        // 1) validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'abstract' =>['required','max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'file_path' =>['required_without:external_url','prohibits:external_url','nullable','file','mimes:pdf,doc,docx','max:5120'],
            'external_url' =>['required_without:file_path','prohibits:file_path','nullable','url'],
            'image_path' =>['nullable','image','max:5120','mimes:jpeg,png,jpg,webp'],
            'areas' => ['required'],
        ]);

        // 2) Creazione nuovo articolo con la data di oggi
        
        //Rimuovi 'users' dai dati della creazione dell'articolo
        // Usiamo collect($validated)->except('users') per pulire l'array
        $articleData = collect($validated)->except(['users', 'areas'])->toArray();

        //preparo i dati
        $articleData['data_pubblicazione'] = now()->toDateString();
        
        // Salvataggio File
        if (request()->hasFile('file_path')) {
            // Salva il PDF e aggiorna il valore nell'array con il percorso stringa
            $articleData['file_path'] = request()->file('file_path')->store('uploads/articles/documents', 'public');
            // store() restituisce il percorso del file appena salvato
        }

        if (request()->hasFile('image_path')) {

            /* Uso la libreria Intervention Image per ridurre il
             peso dell'immagine e convertirla in .webp */
            $file = request()->file('image_path');

            // Leggi l'immagine
            $image = Image::read($file);

            // cover(800,450) =  formato 16:9, ridimensiona l'immagine in modo che il lato più corto sia adatti alla misura richiesta (200px)
            $image->cover(250,250);

            // Converti in WebP (qualità 80%)
            $encoded = $image->toWebp(80);

            // Genera un nome unico con estensione .webp
            $filename = 'uploads/articles/covers/' . uniqid() . '.webp';
            
            /// Salva fisicamente in storage/app/public/articles/covers/
            Storage::disk('public')->put($filename, $encoded->toString());

            // Salva il percorso nel database
            $articleData['image_path'] = $filename;
        }

        // Creazione record nel Database
        $article = Article::create($articleData);

        // Collegamento Autori e aree
        $article->users()->attach(request()->users);
        $article->researchAreas()->attach(request()->areas);

        // 3) redirect
        return redirect('/articles');
    }
}
