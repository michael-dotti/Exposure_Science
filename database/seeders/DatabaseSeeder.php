<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'email' => 'test@example.com',
            'password'=>'password',
        ]);

        $this->call(ArticleSeeder::class);
        User::factory()->defaultAdmin()->withPersonalTeam()->create(); /*NOTA: ho dovuto 
        aggiungere "withPersonaTeam", perché altrimenti se provato a loggare con admin@example.com 
         che è un utente senza team(senza l'aggiutna indciata prima) mi dava errore nella 
         view navigation-menu.blade.php a riga 29 */
        $this->call(ResearchAreaSeeder::class);
    }
}
