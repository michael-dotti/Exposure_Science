<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Languages;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $duration = fake()->numberBetween(1, 12) * 25; // calcolo della durata del corso in numero di ore e in modo tale che sia un multiplo di 25
        $points = $duration / 25; // calcolo dei crediti del corso in base alla durata, considerando che 1 credito corrisponde a 25 ore di corso
        return [
            'title' => ucfirst(fake()->words(rand(3, 5), true)),
            'language' => fake()->randomElement(Languages::cases()),
            'code' => fake()->unique()->regexify('[A-Z]{4}[0-9]{6}'), // genera un codice alfanumerico che inizia con 4 lettere maiuscole seguite da 6 numeri, in alternativa per generare un codice alfanumerico casuale: funzione fake()->unique()->regexify('[A-Z0-9]{10}')
            'points' => $points,
            'semester' => fake()->numberBetween(1, 2),
            'duration' => $duration,
            'description' => fake()->paragraph(),
        ];
    }
}
