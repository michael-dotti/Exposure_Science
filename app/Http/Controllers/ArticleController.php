<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use app\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ArticleController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index()
    {
         $articles = auth()->user()->articles()->with('users')->simplePaginate(5);
 
         return view('articles.index', [
            'articles'=> $articles
                ]);
    }

    // create = porta alla view di creazione di un articolo
    public function create()
    {
        $users = User::all();
        return view('articles.create', compact('users'));
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
            'image_path' =>['nullable','image','max:2048','mimes:jpeg,png,jpg,webp'],
        ]);

        // 2) Creazione nuovo articolo con la data di oggi
        
        //Rimuovi 'users' dai dati della creazione dell'articolo
        // Usiamo collect($validated)->except('users') per pulire l'array
        $articleData = collect($validated)->except('users')->toArray();

        //preparo i dati
        $articleData['data_pubblicazione'] = now()->toDateString();
        
        // Salvataggio File
        if (request()->hasFile('file_path')) {
            // Salva il PDF e aggiorna il valore nell'array con il percorso stringa
            $articleData['file_path'] = request()->file('file_path')->store('articles/documents', 'public');
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
            $filename = 'articles/covers/' . uniqid() . '.webp';
            
            /// Salva fisicamente in storage/app/public/articles/covers/
            Storage::disk('public')->put($filename, (string) $encoded);

            // Salva il percorso nel database
            $articleData['image_path'] = $filename;
        }

        // Creazione record nel Database
        $article = Article::create($articleData);

        // Collegamento Autori
        $article->users()->attach(request()->users);

        // 3) redirect
        return redirect('/articles');
    }

    // edit =porta alla pagina di modifica articolo
    public function edit(Article $article)
    {
        $users = User::select('id', 'name')->get();
        return view('articles.edit', [
            'article' => $article,
            'users' => $users
            ]);
    }

    // update = verifica e aggiorna un articolo
    public function update(Article $article)
    {
        $validated = request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'abstract' => ['required', 'max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'file_path' =>['required_without:external_url','prohibits:external_url','nullable','file','mimes:pdf,doc,docx','max:5120'],
            'external_url' =>['required_without:file_path','prohibits:file_path','nullable','url'],
            'image_path' => ['nullable', 'image', 'max:2048'],
        ]);

        $articleData = collect($validated)->except('users')->toArray();

        if (request()->hasFile('file_path')) {
            // Elimina il vecchio file se esiste (per non sprecare spazio)
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }
            $articleData['file_path'] = request()->file('file_path')->store('articles/documents', 'public');
        }

        if (request()->hasFile('image_path')) {
            // Elimina la vecchia immagine (ma occhio a non eliminare la default.png!)
            if ($article->image_path && $article->image_path !== 'articles/covers/default.png') {
                Storage::disk('public')->delete($article->image_path);
            }
            $articleData['image_path'] = request()->file('image_path')->store('articles/covers', 'public');
        }

        $article->update($articleData);
        $article->users()->sync(request()->users);

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

        return redirect('/articles'); 
    }
}
