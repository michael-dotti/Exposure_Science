<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->unique()->dateTimeInInterval($startDate = '-7 days', $interval = '+ 5 days', $timezone = null);
        $contenents = array('Questo è il contenuto della novità.',
        'Ragazzo della florida in preda ad allucinazioni sposa il proprio banco scolastico',
        'Questa è il contenuto di un notizia diversa.');

        return [
            'titolo' => 'Che notiziona del ' . $date->format('Y-m-d'),
            'created_at' => $date,
            'updated_at' => $date,
            'contenuto' => $contenents[rand(0,2)],
            'dataPubblicazione' => Carbon::now()->toDateString(),
        ];
    }
}
