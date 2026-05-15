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
        'Maria dei Medici era la sesta figlia di Francesco I dei Medici, granduca di Toscana, e di Giovanna di Austria, arciduchessa di Austria, figlia di Ferdinando I di Asburgo, imperatore del Sacro Romano Impero, e di Anna Jagellone.',
        'Questa è il contenuto di un notizia diversa.');

        return [
            'title' => fake()->sentence(rand(1, 3)),
            'content' => $contenents[rand(0,2)],
            'publicationDate' => $date->format('Y-m-d'),//Carbon::now()->toDateString(),
            'imagePath' => 'uploads/news/defaultNews.webp'
        ];
    }
}
