<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

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
        }

        $this->call(UserSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ResearchAreaSeeder::class);
        $this->call(EventSeeder::class);
    }
}
