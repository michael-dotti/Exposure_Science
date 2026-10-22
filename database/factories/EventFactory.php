<?php

namespace Database\Factories;

use App\Enums\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->words(rand(3, 5), true)),
            'creator_user_id' => User::find(3)->id,
            'type' => fake()->randomElement(EventType::cases()),
            'content' => fake()->paragraph()
        ];
    }
}
