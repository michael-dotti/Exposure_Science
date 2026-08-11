<?php

namespace Database\Factories;

use App\Models\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProjectStatusType;

/**
 * @extends Factory<ProjectStatus>
 */
class ProjectStatusFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name' => $this->faker->randomElement(ProjectStatusType::cases()),
            'description' => 'diez nuts',
		];
	}
}
