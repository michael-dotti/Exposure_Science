<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResearchArea>
 */
class ResearchAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Ingegneria', 
            'Fisica', 
            'Matematica', 
            'Storia', 
            'Letteratura Italiana', 
            'Chimica', 
            'Economia', 
            'Informatica'
        ];
        
        return [
            'name' => $this->faker->randomElement($subjects),
            'descrizione' => 'Lorem ipsum dolor sit amet. In quos laboriosam non neque eveniet 33 nihil molestias.
                             Rem perspiciatis iure ut laborum inventore et maxime amet.',
        ];
    }
}
