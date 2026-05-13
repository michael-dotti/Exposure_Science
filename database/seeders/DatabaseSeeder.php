<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (App::environment('local')) // esegui questo codice solo se l'applicazione è ancora in fase di sviluppo (controlla che APP_ENV=local in .env)
        {
            // Pulisce la cartella public dello storage prima di creare nuovi dati (ATTENZIONE!!! rimuove tutti i file degli utenti)
            Storage::disk('public')->deleteDirectory('uploads'); // rimuove tutto dalla cartella 'uploads' in storage/app/public/uploads
            Storage::disk('public')->makeDirectory('uploads'); // ricrea la cartella 'uploads'

            // inserisco le immagini di default degli user in storage cosi da poter usare Accessor
            $imagesUsersName = ['Admin.webp','Emilia_Rossi.webp','Mario_Rossi.webp'];
            
            foreach ($imagesUsersName as $imageName) {
            $sourcePath = public_path('/images/defaultUsers/'. $imageName); // prendo il percorso del file dentro public
                if(File::exists($sourcePath)){ // verifico che il file esisti
                    // leggo il contenuto del file file e lo scrivo nel disco public di storage
                    Storage::disk('public')->put(
                        'uploads/defaultUser/'.$imageName, 
                        File::get($sourcePath));
                }
            }

            $imageArticleName = 'default.webp';
            $sourcePath = public_path('images/'. $imageArticleName);

            if(File::exists($sourcePath)){
                Storage::disk('public')->put(
                    'uploads/articles/covers/'.$imageArticleName, 
                File::get($sourcePath));
            }

            $imageNewsName = 'defaultNews.webp';
            $sourcePath = public_path('images/'. $imageNewsName);

            if(File::exists($sourcePath)){
                Storage::disk('public')->put(
                    'uploads/news/'.$imageNewsName, 
                    File::get($sourcePath));
            }
        }

        
        $this->call(ResearchAreaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(NewsSeeder::class);
    }
}
