<?php

namespace App\Http\Controllers;

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
        return view('news-management.index', ['news' => $news]);
    }

    public function create()
    {
        return view('news-management.create');
    }

    public function store()
    {

        // validazione
        $validated = request()->validate([
            'title' => ['required','min:3','max:128'],
            'content' =>['required','max:60000'],
            'imagePath' =>['required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);
        
        // pulisco il testo da eventuali script malevoli
        $validated['content'] = Purifier::clean($validated['content']); 

        $newsData = collect($validated)->toArray();

        if (request()->hasFile('imagePath')) {

            $file = request()->file('imagePath');
            $image = Image::read($file);
            $image->cover(250,250);
            $encoded = $image->toWebp(80);
            $filename = 'uploads/news/covers/' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $encoded->toString());

            $newsData['imagePath'] = $filename;
        }

        // Creazione record nel Database
        News::create($newsData);

       
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
            'title' => ['required','min:3','max:128'],
            'content' =>['required','max:60000'],
            'imagePath' =>[$imagePath ? 'nullable' : 'required','image','max:5120','mimes:jpeg,png,jpg,webp'],
        ]);

        // pulisco il testo da eventuali script malevoli
        $validated['content'] = Purifier::clean($validated['content']);

        if (request()->hasFile('imagePath')) {
            // Elimina la vecchia immagine
            if ($news->imagePath && $news->imagePath !== 'uploads/news/defaultNews.webp') {
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


       

    public function destroy(News $news){
        if($news->imagePath && $news->imagePath !== 'uploads/news/defaultNews.webp')
        {
            Storage::disk('public')->delete($news->imagePath);
        }

        $news->delete();
        return redirect('/news-management');
    }
}
