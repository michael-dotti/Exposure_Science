<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class NewsManagementController extends Controller
{
    public function index(){
        
        //mostro nella home le tre notizie più nuove
        $news = News::latest()->orderBy('created_at', 'desc')->get();

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users);
        //return view('publicationsPage.index', compact('articles'));
        return view('news-management.index', ['news' => $news]);
    }

    public function create()
    {
        return view('news-management.create');
    }

    public function store()
    {

        //dd("enter here");
        //dd(request());

        // 1) validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'imagePath' =>['nullable','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);

        //dd(request());
        
        $articleData = collect($validated)->toArray();

        if (request()->hasFile('imagePath')) {

            /* Uso la libreria Intervention Image per ridurre il
             peso dell'immagine e convertirla in .webp */
            $file = request()->file('imagePath');

            // Leggi l'immagine
            $image = Image::read($file);

            // cover(800,450) =  formato 16:9, ridimensiona l'immagine in modo che il lato più corto sia adatti alla misura richiesta (200px)
            $image->cover(250,250);

            // Converti in WebP (qualità 80%)
            $encoded = $image->toWebp(80);

            // Genera un nome unico con estensione .webp
            $filename = 'uploads/news/covers/' . uniqid() . '.webp';
            
            /// Salva fisicamente in storage/app/public/articles/covers/
            Storage::disk('public')->put($filename, $encoded->toString());

            // Salva il percorso nel database
            $articleData['imagePath'] = $filename;
        }

        // Creazione record nel Database
        $article = News::create($articleData);

        // 3) redirect
        return redirect('/news-management');
    }
}
