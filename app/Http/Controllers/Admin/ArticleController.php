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
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index(Request $request)
    {
        $areas = ResearchArea::all();
        $users = null;

        /** @var \App\Models\User $authenticatedUser */
        $authenticatedUser = $request->user();

        if ($authenticatedUser->hasPermissionTo('edit all articles')) {
            $articles = Article::with(['users', 'researchAreas']);
            $users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();
        } else {
            $articles = $authenticatedUser
                ->articles()
                ->with(['users', 'researchAreas']);
        }

        $articles = $articles
            ->filterByArea($request->query('areaId'))
            ->filterByUser($request->query('userId'))
            ->latest()
            ->Paginate(5)
            ->onEachSide(1)
            ->withQueryString(); // Mantiene i parametri nell'URL cosi da non perdere il filtraggio mentre ti sposti tra le pagine della paginazione

        // Preparlo gli array per i filtri attivi
        $currentFilters = [];

        // L'IF CONTROLLA SE IL PARAMETRO userID ESISTE NELL'URL E CHE NON SIA VUOTO
            // $user?->... = se è null laravel non va in errore ma restitusice semplicemente NULL
            // firstWhere('id', $request->query('userId')) = Cerca nella collezione degli utenti già recuperati dal database il primo utente che ha l'ID uguale a quello presente nell'URL.
            // $selectedUser = ... -> Assegna l'utente trovato alla variabile $selectedUser
        if ($request->filled('userId') && $selectedUser = $users?->firstWhere('id', $request->query('userId'))) {
            $currentFilters[] = [ // $currentiFilters[] = [...] -> aggiunge in coda all'array $currentFilters() la struttura richiesta dal component efilter-box: label (intestazioen del filtro) e un valore (nome e cognome dell'utente concatenati)
                'label' => 'Autore',
                'value' => $selectedUser->name . ' ' . $selectedUser->surname
            ];
        }

        // ANALOGO AL CASO PER userID
        if ($request->filled('areaId') && $selectedArea = $areas->firstWhere('id', $request->query('areaId'))) {
            $currentFilters[] = [
                'label' => 'Area',
                'value' => $selectedArea->name
            ];
        }

        return view(
            'admin.articles.index',
            compact('articles', 'areas', 'users', 'currentFilters')
        );
    }

    // create = porta alla view di creazione di un articolo
    public function create()
    {
        // carico delle tabelle Users e ResearchAreas per il form solo le colonne necessarie (id e name) per non appesantire la quer
        $users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')->get();
        
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
        // 1) validazione
        $validated = request()->validate([
            'title' => ['required', 'min:3', 'max:255', 'unique:articles,title'],
            'abstract' =>['required','min:30','max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'users.*' => ['required', 'exists:users,id'],
            
            'file_path' => [
                'required_without:external_url',
                'prohibits:external_url',
                Rule::when(request()->hasFile('file_path'), [
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:51200',
                ]),
            ],
            
            'external_url' => [
                'required_without:file_path',
                'prohibits:file_path',
                Rule::when(request()->filled('external_url'), [
                    'url',
                    'max:1024',
                ]),
            ],

            'image_path' =>['required','image','max:5120','mimes:jpeg,png,jpg,webp'],
            'areas' => ['required','array','min:1'],
            'areas.*' => [Rule::enum(ResearchArea::class)],
        ]);

        // 1.1) Ripulire l'articolo da eventuali script malevoli
        $validated['abstract'] = Purifier::clean($validated['abstract']);

        // 1.2) Rimuovi 'users' e 'researchareas' dai dati della creazione dell'articolo
        // Usiamo collect($validated)->except('users') per pulire l'array
        $articleData = collect($validated)->except(['users', 'areas','file_path'])->toArray();


        // 2) Creazione nuovo articolo con la data di oggi
        //preparo i dati
        $articleData['external_url'] = request()->filled('external_url') ? request()->input('external_url') : null; // se external_url non è esplicitamente assegnato, gli assegno il valore null
        $articleData['data_pubblicazione'] = now()->toDateString();
        
        if (request()->hasFile('image_path')) {

            /* Uso la libreria Intervention Image per ridurre il
             peso dell'immagine e convertirla in .webp */
            $file = request()->file('image_path');

            // Leggi l'immagine
            $image = Image::read($file);

            //invece un cover(800,450) genererebbe: formato 16:9, ridimensiona l'immagine in modo che il lato più corto sia adatti alla misura richiesta (200px)
            $image->cover(600,600);

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

            // gestione autori
            $users = request()->input('users', []);

            // Se NON è Admin, forzol'aggiunta dell'utente corrente (una sola volta)
            if (! Auth::user()->hasPermissionTo('edit all articles') && ! in_array(Auth::id(), $users)) {
                $users[] = Auth::id();
            }

            // Collegamento Autori e Aree di ricerca
            $article->users()->attach($users);
            $article->researchAreas()->attach(request()->input('areas', []));
        });

        // 3) redirect
        return redirect()->route('admin.articles.index')->with(
                'success',
                'Articolo creato correttamente.'
            ); //Nota Bene: il redirect ha bisogno dell'url. Si usa il redirect dopo aver modificato il database
    }

    // edit =porta alla pagina di modifica articolo
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        // carico delle tabelle Users e ResearchAreas per il form solo le colonne necessarie (id e name) per non appesantire la quer
        $users = User::select('id', 'name','surname')
            ->orderBy('surname','asc')
            ->orderBy('name', 'asc')
            ->get();
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
        $hasImage = $article->image_path;

        $validated = request()->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('articles', 'title')->ignore($article->id)],
            'abstract' => ['required','min:30', 'max:3000'],
            'users' => ['required', 'array', 'min:1'],
            'areas' => ['required', 'array', 'min:1'],
            
            // Applica le regole sul file SOLO se l'utente sta effettivamente caricando un file nuovo
            'file_path' => [
                $hasExistingFile ? 'nullable' : 'required_without:external_url',
                'prohibits:external_url',
                Rule::when(request()->hasFile('file_path'), [
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:51200',
                ]),
            ],
            
            // Applica la regola 'url' SOLO se l'utente ha scritto qualcosa nel campo
            'external_url' => [
                $hasExistingFile ? 'nullable' : 'required_without:file_path',
                'prohibits:file_path',
                Rule::when(request()->filled('external_url'), [
                    'url', 
                    'max:1024',
                ]),
            ],
            
            'image_path' => [$hasImage ? 'nullable' : 'required', 'image', 'max:5120', 'mimes:jpeg,png,jpg,webp'],
        ]);

        $articleData = collect($validated)->except(['users', 'areas','file_path'])->toArray();
        $articleData['abstract'] = Purifier::clean($articleData['abstract']);


        if (request()->hasFile('image_path')) {
            // Elimina la vecchia immagine
            if ($article->image_path && $article->image_path !== 'uploads/articles/covers/default.webp') {
                Storage::disk('public')->delete($article->image_path);
            }

            $file = request()->file('image_path');

            // Leggi l'immagine
            $image = Image::read($file);
            // ridimensiona l'immagine in modo che il lato più corto sia adatti alla misura richiesta (250px)
            $image->cover(600,600);
            // Converti in WebP (qualità 80%)
            $encoded = $image->toWebp(80);
            // Genera un nome unico con estensione .webp
            $filename = 'uploads/articles/covers/' . uniqid() . '.webp';
            /// Salva fisicamente in storage/app/public/articles/covers/
            Storage::disk('public')->put($filename, $encoded->toString());
            // Salva il percorso nel database
            $articleData['image_path'] = $filename;
        }
        else {
            unset($articleData['image_path']);
        }

        // &$NomeVar == passaggio per riferimento
        DB::transaction(function () use ($article, &$articleData) {
            
            // CASO 1: L'utente ha inserito un URL esterno (rimuovo l'eventuale file esistente)
            if (request()->filled('external_url')) {
                if ($article->document) {
                    Storage::disk('public')->delete($article->document->file_path);
                    $article->document()->delete();
                }
                $articleData['external_url'] = request()->input('external_url');
            }
            
            // CASO 2: L'utente ha caricato un nuovo file (rimuovo l'eventuale file precedente e azzero l'URL)
            elseif (request()->hasFile('file_path')) {
                if ($article->document) {
                    Storage::disk('public')->delete($article->document->file_path);
                }
                
                $file = request()->file('file_path');
                $path = $file->store('uploads/articles/documents', 'public');

                $article->document()->updateOrCreate(
                    [],
                    [
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize()
                    ]
                );

                // L'articolo ora ha un file, quindi l'external_url deve essere null
                $articleData['external_url'] = null;
                $article->load('document');
            }
            
            // CASO 3: Rimozione esplicita del file
            elseif (request()->input('remove_file') == '1') {
                if ($article->document) {
                    Storage::disk('public')->delete($article->document->file_path);
                    $article->document()->delete();
                }
            }

            $article->update($articleData);
            
            // gestione autori
            $users = request()->input('users', []);

            // Se l'utente NON è Admin ed era già tra gli autori, non gli permettiamo di sfilarsi tramite sync
            if (! Auth::user()->hasPermissionTo('edit all articles') && $article->users->contains(Auth::id())) {
                if (! in_array(Auth::id(), $users)) {
                    $users[] = Auth::id();
                }
            }

            $article->users()->sync($users);
            $article->researchAreas()->sync(request()->input('areas', []));
        });

        return redirect()->route('admin.articles.index')->with(
                'success',
                'Articolo modificato correttamente.'
            ); //Nota Bene: Si usa il redirect dopo aver modificato il database
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
        return $this->redirectBackOrTo('admin.articles.index')->with(
                'success',
                'Articolo eliminato correttamente.'
            );
    }
    
}
