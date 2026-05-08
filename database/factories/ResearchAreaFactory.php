<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ResearchAreaType;

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
        return [
            'nome' => $this->faker->randomElement(ResearchAreaType::cases()),
            'descrizione' => 'Lorem ipsum dolor sit amet. In quos laboriosam non neque eveniet 33 nihil molestias.
                             Rem perspiciatis iure ut laborum inventore et maxime amet.',
        ];
    }
}
