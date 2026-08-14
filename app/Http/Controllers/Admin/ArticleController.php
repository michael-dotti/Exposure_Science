<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ResearchArea;
use Illuminate\Support\Facades\Gate;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Article::class);

        $areas = ResearchArea::all();
        $users = null;

        /** @var \App\Models\User $authenticatedUser */
        $authenticatedUser = $request->user();

        if ($authenticatedUser->hasPermissionTo('edit all articles')) {
            $articles = Article::with(['users', 'researchAreas']);
            $users = User::all();
        } else {
            $articles = $authenticatedUser
                ->articles()
                ->with(['users', 'researchAreas']);
        }

        $articles = $articles
            ->filterByArea($request->query('areaId'))
            ->filterByUser($request->query('userId'))
            ->latest()
            ->simplePaginate(5)
            ->withQueryString(); // Mantiene i parametri nell'URL cosi da non perdere il filtraggio mentre ti sposti tra le pagine della paginazione

        return view(
            'admin.articles.index',
            compact('articles', 'areas', 'users')
        );
    }

    // create = porta alla view di creazione di un articolo
    public function create()
    {
        // già controllato nelle rotte, ma per chiarezza
        Gate::authorize('create', Article::class);

        // carico delle tabelle Users e ResearchAreas per il form solo le colonne necessarie (id e name) per non appesantire la quer
        $users = User::select('id', 'name')->get();
        $areas = ResearchArea::select('id', 'name')->get();
        return view('admin.articles.create', compact('users','areas'));
    }

    //Show= porta alla view per vedere un singolo articolo
    public function show(Article $article)
    {
        Gate::authorize('view', $article);
        return view('admin.articles.show', ['article' => $article]);    
    }

    // store = esegue l'autenticazione e poi aggiunge un articolo
    public function store()
    {
        Gate::authorize('create', Article::class);
        
        // 1) validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'abstract' =>['required','max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'file_path' =>['required_without:external_url','prohibits:external_url','nullable','file','mimes:pdf,doc,docx','max:51200'],
            'external_url' =>['required_without:file_path','prohibits:file_path','nullable','url'],
            'image_path' =>['nullable','image','max:5120','mimes:jpeg,png,jpg,webp'],
            'areas' => ['required','array','min:1'],
        ]);

        // 1.1) Ripulire l'articolo da eventuali script malevoli
        $validated['abstract'] = Purifier::clean($validated['abstract']);

        // 1.2) Rimuovi 'users' e 'researchareas' dai dati della creazione dell'articolo
        // Usiamo collect($validated)->except('users') per pulire l'array
        $articleData = collect($validated)->except(['users', 'areas','file_path'])->toArray();


        // 2) Creazione nuovo articolo con la data di oggi
        //preparo i dati
        $articleData['data_pubblicazione'] = now()->toDateString();
        
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

        DB::transaction(function () use ($articleData) {

            // Creazione record nel Database
            $article = Article::create($articleData);

            // Salvataggio e creazione File nel database
            if (request()->hasFile('file_path')) {
                // 1. Recupera il file
                $file = request()->file('file_path');
                
                // 2. salvo il file e prendo il percorso
                $path = $file->store('uploads/articles/documents','public');

                // 3. creo il nuovo record File e lo lego ad article
                $article->document()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getClientMimeType(), // recupera il Mime Type reale del file
                    'file_size' => $file->getSize() // recupera la dimensione esatta in byte
                ]);
            }

            $users = request()->users;

            //rimuovo il creatore dall'array dei partecipanti
            //la sua incusione è trattata singolarmente
            //in questo modo ho la certezza di inserirlo e di inserirlo una sola volta
            if (($key = array_search(Auth::user()->id, $users)) !== false) {
                unset($users[$key]);
            }

            // Collegamento Autori e aree
            $article->users()->attach($users);
            $article->users()->attach(Auth::user());
            $article->researchAreas()->attach(request()->areas);
        });

        // 3) redirect
        return redirect()->route('admin.articles.index'); //Nota Bene: il redirect ha bisogno dell'url. Si usa il redirect dopo aver modificato il database
    }

    // edit =porta alla pagina di modifica articolo
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        // carico delle tabelle Users e ResearchAreas per il form solo le colonne necessarie (id e name) per non appesantire la quer
        $users = User::select('id', 'name')->get();
        $areas = ResearchArea::select('id', 'name')->get();

        // (non necessario ma consigliato) Carico le relazioni già esistenti per l'articolo
        // serve a Blade per sapere quali relazioni sono già selezionati senza fare altre query
        $article->load(['users', 'researchAreas']);

        return view('admin.articles.edit', compact('article', 'users', 'areas'));
    }

    // update = verifica e aggiorna un articolo
    public function update(Article $article)
    {
        Gate::authorize('update', $article);

       $hasExistingFile = $article->document()->exists() && request()->input('remove_file') !== '1';    

        $validated = request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'abstract' => ['required', 'max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'areas' => ['required', 'array', 'min:1'],
            'file_path' => [ $hasExistingFile ? 'nullable' : 'required_without:external_url','prohibits:external_url','file','mimes:pdf,doc,docx','max:51200'],
            'external_url' => [$hasExistingFile ? 'nullable' : 'required_without:file_path','prohibits:file_path','url', 'max:1024'],
            'image_path' => ['nullable', 'image', 'max:5120'],
        ]);

        $articleData = collect($validated)->except(['users', 'areas','file_path'])->toArray();
        $articleData['abstract'] = Purifier::clean($articleData['abstract']);


        if (request()->hasFile('image_path')) {
            // Elimina la vecchia immagine
            if ($article->image_path && $article->image_path !== 'articles/covers/default.png') {
                Storage::disk('public')->delete($article->image_path);
            }

            $file = request()->file('image_path');

            // Leggi l'immagine
            $image = Image::read($file);
            // ridimensiona l'immagine in modo che il lato più corto sia adatti alla misura richiesta (250px)
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
        elseif (request()->input('remove_photo') == '1'){
                if($article->image_path){
                    Storage::disk('public')->delete($article->image_path);
                }

                $articleData['image_path']  = null;
        }
        else {
            unset($articleData['image_path']);
        }

        DB::transaction(function () use ($article, $articleData) {
            $article->update($articleData);

            if (request()->hasFile('file_path')) {
                // Elimina il vecchio file se esiste (per non sprecare spazio)
                if ($article->document) {
                    Storage::disk('public')->delete($article->document->file_path);
                }
                
                $file = request()->file('file_path');
                $path = $file->store('uploads/articles/documents','public');

                $article->document()->updateOrCreate(
                    [],
                    [
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize()
                    ]
                );

                // Ricarica la relazione aggiornata per svuotare la cache in memoria
                $article->load('curriculum');
            }
            // 
            elseif (request()->input('remove_file') == '1' || request()->filled('external_url')) {
                if ($article->document) {
                    // Elimina il file fisico dal disco
                    Storage::disk('public')->delete($article->document->file_path);
                    // Elimina la riga dal database
                    $article->document()->delete();
                }
            }

            $users = request()->users;

            //rimuovo il creatore dall'array dei partecipanti
            //la sua incusione è trattata singolarmente
            //in questo modo ho la certezza di inserirlo e di inserirlo una sola volta
            if (($key = array_search(Auth::user()->id, $users)) !== false) {
                unset($users[$key]);
            }
            $users[] = $article->creator_id;

            $article->users()->sync($users);
            $article->researchAreas()->sync(request()->areas);
        }
        );

        return redirect()->route('admin.articles.index'); //Nota Bene: il redirect ha bisogno dell'url. Si usa il redirect dopo aver modificato il database
    }

    // destroy = distrugge un articolo
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        // 1) Elimina il file fisico se esiste
        if ($article->image_path && $article->image_path !== 'uploads/articles/covers/default.webp') {
            Storage::disk('public')->delete($article->image_path);
        }

        if ($article->file_path) {
            Storage::disk('public')->delete($article->file_path);
        }

        // 2) Elimina il record dal database
        $article->delete();

        // 4) redirect: Si usa il redirect dopo aver modificato il database
        return $this->redirectBackOrTo('admin.articles.index');
    }
    
}
