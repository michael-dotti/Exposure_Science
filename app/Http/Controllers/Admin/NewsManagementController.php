<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class NewsManagementController extends Controller
{
    public function index()
    {    
        $news = News::latest()->get();
        return view('admin.news-management.index', ['news' => $news]);
    }

    public function show(News $news)
    {
        return view('admin.news-management.show', ['news' => $news]);
    }
    
    public function create()
    {
        return view('admin.news-management.create');
    }

    public function store()
    {
        // validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:128'],
            'content' =>['required','max:60000'],
            'image_path' =>['required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);
        
        // pulisco il testo da eventuali script malevoli
        $validated['content'] = Purifier::clean($validated['content']); 

        $newsData = collect($validated)->toArray();

       
        // salva l'immagine 
        $file = request()->file('image_path');
        $image = Image::read($file);
        
        // Ritaglia a 1200px di larghezza e 675px di altezza (Proporzione 16:9)
        $image->cover(1200, 675);
        
        $encoded = $image->toWebp(80);
        $filename = 'uploads/news/covers/' . uniqid() . '.webp';
        Storage::disk('public')->put($filename, $encoded->toString());

        $newsData['image_path'] = $filename;
        

        // Creazione record nel Database
        News::create($newsData);

       
        return redirect()->route('admin.news-management.index');
    }

    public function edit(News $news)
    {
        return view('admin.news-management.edit', ['news' => $news]);
    }

    public function update(News $news)
    {
        $image_path = $news->image_path;
        
        $validated = request()->validate([
            'title' => ['required','min:3','max:128'],
            'content' =>['required','max:60000'],
            'image_path' =>[$image_path ? 'nullable' : 'required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);

        // pulisco il testo da eventuali script malevoli
        $validated['content'] = Purifier::clean($validated['content']);

        if (request()->hasFile('image_path')) {
            // Elimina la vecchia immagine
            if ($news->image_path && $news->image_path !== 'uploads/news/defaultNews.webp') {
                Storage::disk('public')->delete($news->image_path);
            }

            $file = request()->file('image_path');

            $image = Image::read($file);

            // Ritaglia a 1200px di larghezza e 675px di altezza (Proporzione 16:9)
            $image->cover(1200, 675);
            
            $encoded = $image->toWebp(80);
            $filename = 'uploads/news/' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $encoded->toString());
            $validated['image_path'] = $filename;

        } else {
            unset($validated['image_path']);
        }

        $news->update($validated);
        return redirect()->route('admin.news-management.index');
    }


       

    public function destroy(News $news)
    {
        if($news->image_path && $news->image_path !== 'uploads/news/defaultNews.webp')
        {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return $this->redirectBackOrTo('admin.news-management.index');
    }
}
