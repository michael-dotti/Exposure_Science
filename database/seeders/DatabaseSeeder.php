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

            $imagesNewsName = ['defaultNews_0.webp','defaultNews_1.webp','defaultNews_2.webp','defaultNews_3.webp',
                'defaultNews_4.webp','defaultNews_5.webp','defaultNews_6.webp','defaultNews_7.webp',
                'defaultNews_8.webp','defaultNews_9.webp'];
            
            foreach ($imagesNewsName as $imageNewsName) {
                $sourcePath = public_path('images/'. $imageNewsName);

                if(File::exists($sourcePath)){
                    Storage::disk('public')->put(
                        'uploads/news/'.$imageNewsName, 
                        File::get($sourcePath));
                }
            }

            //1) prendi nome file
            //2) prendi percorso public file
            // 3) verifica che file esista
            // 4) se si, caricalo su storage in: uploads/résumé/NomeFIle

            $fileCurriculumName = 'default_curriculum.pdf';
            $sourcePath = public_path('curriculum/' . $fileCurriculumName);

            if(File::exists($sourcePath)){
                Storage::disk('public')->put(
                    'uploads/curriculum/' . $fileCurriculumName,
                    File::get($sourcePath)
                );
            }

            $fileResumeName = 'default_piano_di_studi_triennale_Ingegneria.pdf';
            $sourcePath = public_path('images/defaultEventAttachments/'. $fileResumeName);

            if(File::exists($sourcePath)){
                Storage::disk('public')->put(
                    'uploads/events/attachments/' . $fileResumeName,
                    File::get($sourcePath)
                );
            }
        }

        $this->call(RoleAndPermissionSeeder::class); // deve essere aggiunto prima della chiamata di UserSeeder, altrimenti assegno agli user di default ruoli che non esistono ancora
        $this->call(ResearchAreaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
