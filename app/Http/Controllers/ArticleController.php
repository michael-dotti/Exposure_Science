<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use app\Models\User;
use Illuminate\Support\Facades\Storage;

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

    // create= porta alla view di creaizone di un articolo
    public function create()
    {
        $users = User::all();
        return view('articles.create', compact('users'));
    }

    //Show= porta alla view per vedere un singolo articolo
    public function show(Article $article)
    {
        //    
    }

    // store = esegue l'autenticazione e poi aggiunge un articolo
    public function store()
    {
        
        // 1) validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'abstract' =>['required','max:5000'],
            'users' => ['required', 'array', 'min:1'],
            'file_path' =>['required_without:external_url','nullable','file','mimes:pdf,doc,docx','max:5120'],
            'external_url' =>['required_without:file_path','nullable','url'],
            'image_path' =>['nullable','image','max:2048'],
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
        }

        if (request()->hasFile('image_path')) {
            // Salva l'immagine e aggiorna il valore
            $articleData['image_path'] = request()->file('image_path')->store('articles/covers', 'public');
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
        //
    }

    // update = verifica e aggiorna un articolo
    public function update(Article $article)
    {
        //
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

        return redirect()->back(); 
    }
}
