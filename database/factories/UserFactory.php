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
use Illuminate\Support\Facades\Storage;

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


    public function defaultAdmin(): static
    {
        return $this->state(fn (array $attributes) => [ 
            'name'=>'Renzo',
            'surname'=>'Tramaglino',
            'email'=>'admin@example.com',
            'password'=>static::$password ??= Hash::make('password'),
            'profile_photo_path' => 'uploads/defaultUser/Admin.webp', 
            'website' => 'https://it.wikipedia.org/wiki/Renzo_Tramaglino',
            'bio' => "Io sono un povero filatore di seta di queste terre, e Lucia Mortadella è la mia promessa sposa davanti a Dio.
            Ma quel birbone di Don Rodrigo, per un suo capriccio malvagio, ha messo sottosopra il mondo per impedirci di essere marito e moglie. 
            Ha usato la forza e l'inganno contro noi poveri cristiani, e ora ci tocca fuggire come banditi dalla nostra stessa casa.  
            Sono l'attuale amministratore del gruppo di ricerca ",
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
         
        // 1. Definisco il percorso relativo del curriculm (un file) di defaul (a partire da storage/app/public/)
        $defaultCvPath = 'uploads/curriculum/default_curriculum.pdf';

        // 2. Recupero le informazioni reali del file usando Storage (se il file esiste)
        $disk = Storage::disk('public');
        $fileSize = $disk->exists($defaultCvPath) ? $disk->size($defaultCvPath) : 0;
        
        // Assegno il mimeType fisso, dato che so che è un PDF
        $mimeType = 'application/pdf';

        $mario = $this->withPersonalTeam()->create([
            'name' => 'Mario',
            'surname' => 'Rossi',
            'email' => 'test1@example.com',
            'password'=>'password',
            'profile_photo_path' => 'uploads/defaultUser/Mario_Rossi.webp',
            'bio' => <<<EOT
            Sono Mario Rossi, ho 27 anni e sono uno studioso di analisi applicata alla statistica qui a Brescia.
            La mia ricerca ha come fulcro l'applicazione di costrutti matematici iperbo-parabolici su problemi
            analitici complessi che le persone possono imbattersi in un contesto giornaliero.
            Questi problemi includono la ricerca di stabilità e controllo ottimale su sistemi matematicamente 
            caotici come: crowd dynamics, flusso del traffico, dinamiche dei gas e molto altro.
            EOT,
        ]);

        $mario->assignRole(['reliable researcher','teacher']);
        
        // 3. creo il curriculm con i dati estratti prima
        $mario->curriculum()->create([
            'file_name' => 'default_CV.pdf',
            'file_path' => $defaultCvPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize, 
        ]);

        $emilia = $this->withPersonalTeam()->create([
            'name' => 'Emilia',
            'surname' => 'Rossi',
            'email' => 'test2@example.com',
            'password' => 'password',
            'profile_photo_path' => 'uploads/defaultUser/Emilia_Rossi.webp',
            'bio' => <<<EOT
            Sono Emilia Rossi, 31 anni, e la mia professione è storica dell'arte con
            specializzazione in opere prodotte nelle zone del bresciano tra il XIV e XVII secolo.
            Il mio lavoro consiste nella ricerca storica, restauro e divulgazione al pubblico delle
            opere d'arte del territorio.
            Vanto numerose pubblicazioni con importanti case editrici, i testi di mia produzione sono
            utilizzati anche come referenza per testi scolastici e opere derivate.
            EOT,
        ]);
        $emilia->assignRole(['news Manager']);
        $emilia->curriculum()->create([
            'file_name' => 'default_CV.pdf',
            'file_path' => $defaultCvPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize, 
        ]);

        $admin = $this->defaultAdmin()->withPersonalTeam()->create();
        $admin->assignRole('admin');
        $admin->curriculum()->create([
            'file_name' => 'default_CV.pdf',
            'file_path' => $defaultCvPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
        ]);
    }

}
