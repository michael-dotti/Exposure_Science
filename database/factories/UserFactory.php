<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    public function admin(): static
     {
       return $this->state(fn (array $attributes) => [ 
         'admin' => true,
         ]);
    }

    public function defaultAdmin(): static
    {
        return $this->state(fn (array $attributes) => [ 
            'name'=>'Renzo',
            'surname'=>'Tramaglino',
            'email'=>'admin@example.com',
            'password'=>static::$password ??= Hash::make('password'),
            'profile_photo_path' => 'uploads/defaultUser/Admin.webp', 
            'bio' => "Io sono un povero filatore di seta di queste terre, e Lucia Mondella è la mia promessa sposa davanti a Dio.
            Ma quel birbone di Don Rodrigo, per un suo capriccio malvagio, ha messo sottosopra il mondo per impedirci di essere marito e moglie. 
            Ha usato la forza e l'inganno contro noi poveri cristiani, e ora ci tocca fuggire come banditi dalla nostra stessa casa.  
            Sono l'attuale amministratore del gruppo di ricerca ",
            'curriculm_file_path' => 'public/resume/default_resume.pdf',
         ]);
    }
    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }


    public function createDefaultUsers(): void
    {
        /*NOTA: ho dovuto 
        aggiungere "withPersonaTeam", perché altrimenti se provato a loggare con admin@example.com 
         che è un utente senza team(senza l'aggiutna indciata prima) mi dava errore nella 
         view navigation-menu.blade.php a riga 29 */
         
        $this->withPersonalTeam()->create([
            'name' => 'Mario',
            'surname' => 'Rossi',
            'email' => 'test1@example.com',
            'password'=>'password',
            'profile_photo_path' => 'uploads/defaultUser/Mario_Rossi.webp',
            'bio' => <<<EOT
            Sono Mario Rossi, ho 27 anni e lavoro come Liutaio di Strumenti Elettronici.
            Fondo il legno pregiato con circuiti analogici fatti a mano per creare sintetizzatori che suonano
            come violini antichi, dopo aver studiato ingegneria a Milano e falegnameria a Cremona. Amo cucinare piatti della
            tradizione contadina seguendo ricette scritte in codice binario sul mio blog. Segretamente, ho inserito una frequenza
            impercettibile in ogni strumento che produco, capace di far vibrare leggermente i bicchieri di cristallo quando
            viene suonata una nota specifica.
            EOT,
            'curriculm_file_path' => 'public/resume/default_resume.pdf',
        ])->assignRole('reliable researcher');

        $this->withPersonalTeam()->create([
            'name' => 'Emilia',
            'surname' => 'Rossi',
            'email' => 'test2@example.com',
            'password' => 'password',
            'profile_photo_path' => 'uploads/defaultUser/Emilia_Rossi.webp',
            'bio' => <<<EOT
            Sono Emilia Rossi, 31 anni, e la mia professione è "Designer di Esperienze Olfattive". 
            Creo profumi non per il corpo, ma per gli spazi: installazioni effimere in gallerie d'arte o ambienti privati,
             capaci di evocare ricordi specifici o indurre stati d'animo. Il mio naso è il mio strumento principale,
              affinato da anni di studio in Grasse. Nel tempo libero, compongo fragranze "cattive" che nessuno oserebbe 
              indossare, ma che per me rappresentano sfide olfattive uniche. Nessuno sa che il mio senso dell'olfatto è
               così sviluppato da poter distinguere l'età di una bottiglia di vino solo annusando il sughero.
            EOT,
            'curriculm_file_path' => 'public/resume/default_resume.pdf',
        ])->assignRole(['news Manager']);

        $this->defaultAdmin()->withPersonalTeam()->create()->assignRole('admin');
    }

    /**
     * configure: metodo eseguito sempre appena la factory viene invocata
     * in questo caso, assegno il ruolo di default  "researcher" a tutti gli utenti creati con la factory
     */
    public function configure(): static
    {
        // afterCreating viene eseguito dopo che l'utente è stato creato nel database
        return $this->afterCreating(function (User $user) {
            $user->assignRole('researcher');
        });
    }
}
