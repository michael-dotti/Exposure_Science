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
        $areaType = $this->faker->unique()->randomElement(ResearchAreaType::cases());
        
        return [
            'name' => $areaType->value,
            'description' => $areaType->description(),
        ];
    }
}
