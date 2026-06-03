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

        // 1) validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'imagePath' =>['required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);
        
        $newsData = collect($validated)->toArray();

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
            $newsData['imagePath'] = $filename;
        }

        //$newsData

        // Creazione record nel Database
        $article = News::create($newsData);

        // 3) redirect
        return redirect('/news-management');
    }

    public function edit(News $news)
    {
        return view('news-management.edit', ['news' => $news]);
    }

    public function update(News $news)
    {
        $imagePath = $news->imagePath;
        
        $validated = request()->validate([
            'title' => ['required','min:3','max:255'],
            'content' =>['required','max:5000'],
            'imagePath' =>[$imagePath ? 'nullable' : 'required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);

        if (request()->hasFile('imagePath')) {
            if ($news->imagePath && $news->imagePath !== 'news/defaultNews.png') {
                Storage::disk('public')->delete($news->imagePath);
            }

            $file = request()->file('imagePath');

            $image = Image::read($file);
            $image->cover(250,250);
            $encoded = $image->toWebp(80);
            $filename = 'uploads/news/' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $encoded->toString());
            $validated['imagePath'] = $filename;
        } else {
            unset($validated['imagePath']);
        }

        $news->update($validated);

        return redirect('/news-management');
    }

    public function destroy(News $news) {
        if($news->imagePath && $news->imagePath !== 'uploads/news/defaultNews.webp') {
            Storage::disk('public')->delete($news->imagePath);
        }

        $news->delete();

        return redirect('/news-management');
    }
}
