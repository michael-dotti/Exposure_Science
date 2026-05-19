<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ResearchArea;

class ArticleController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        /* ho dovuto fare questo passaggio, invece che scrivere 
            "$articles = auth()->user()->articles()->with('users')->simplePaginate(5);"
        Perchè il mio compilatore, erroneamente, mi dava errore
        */        
        $articles = $user->articles()->with('users')->latest()->simplePaginate(5);
 
         return view('articles.index', [
            'articles'=> $articles
                ]);
    }

    // create = porta alla view di creazione di un articolo
    public function create()
    {
        $users = User::all();
        $areas = ResearchArea::all();
        return view('articles.create', compact('users','areas'));
    }

    //Show= porta alla view per vedere un singolo articolo
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);    
    }

    // store = esegue l'autenticazione e poi aggiunge un articolo
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

    // edit =porta alla pagina di modifica articolo
    public function edit(Article $article)
    {
        $users = User::select('id', 'name')->get();
        $areas = ResearchArea::select('id', 'name')->get();

        // (non necessario ma consigliato) Caro le relazioni già esistenti per l'articolo
        // serve a Blade per sapere quali relazioni sono già selezionati senza fare altre query
        $article->load(['users', 'researchAreas']);

        return view('articles.edit', compact('article', 'users', 'areas'));
    }

    // update = verifica e aggiorna un articolo
    public function update(Article $article)
    {

        dd(request());

        $validated = request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'abstract' => ['required', 'max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'file_path' =>['required_without:external_url','prohibits:external_url','nullable','file','mimes:pdf,doc,docx','max:5120'],
            'external_url' =>['required_without:file_path','prohibits:file_path','nullable','url'],
            'image_path' => ['nullable', 'image', 'max:5120'],
        ]);

        $articleData = collect($validated)->except(['users', 'areas'])->toArray();

        if (request()->hasFile('file_path')) {
            // Elimina il vecchio file se esiste (per non sprecare spazio)
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }

            $articleData['file_path'] = request()->file('file_path')->store('uploads/articles/documents', 'public');
        } elseif (request()->input('remove_file') == '1'){
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }

            $articleData['file_path'] = null;
        } else {
            unset($articleData['file_path']);
        }

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
                $validated['image_path'] = null;
        }
        else {
            unset($validated['image_path']);
        }

        $article->update($articleData);
        $article->users()->sync(request()->users);
        $article->researchAreas()->sync(request()->areas);

        return redirect('/articles');
    }

    // destroy = distrugge un articolo
    public function destroy(Article $article)
    {
        // 1) Elimina il file fisico se esiste
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        if ($article->file_path) {
            Storage::disk('public')->delete($article->file_path);
        }

        // 2) Elimina il record dal database
        $article->delete();

        // 4) redirect
        return redirect('/articles'); 
    }
}
