<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$s_date = fake()->dateTimeBetween('-8 week', '-4 week');
		$e_date = fake()->dateTimeBetween('-3 week', '+6 week');

		$finanziatori = array("Monti dei Paschi di Siena", "Banco Agricolo Campano",
				"Università degli Studi di Brescia", "Università degli Studi di Milano", "Università Statale di Bergamo",
				"Comune di Pavia", "Comune di Brscia", "Marcello", "mio zio", "Università degli Studi di Capodimonte",
				"Comune di Melegnano", "Comune di Vello", "New York MoMA", "Crypton Future Media Inc.", "ASST Franciacorta",
				"Comune di Orzinuovi");

		$finanziatore = (random_int(0, 100) < 75)? $finanziatori[random_int(0,sizeof($finanziatori) - 1)] : null;

		return [
			'title' => fake()->sentence(3),
			'description' => fake()->sentence(80),
			'funding_agency' => $finanziatore,
			'status' => "planned",
			'start_date' => $s_date,
			'end_date' => $e_date,
		];
	}
}
