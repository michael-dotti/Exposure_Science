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
        $contenents = array(
            'Se ni mondo esistesse un po di bene e ognun si honsiderasse suo fratello ci sarebbe meno pensieri e meno pene e il mondo ne sarebbe assai più bello',
            'Maria dei Medici era la sesta figlia di Francesco I dei Medici, granduca di Toscana, e di Giovanna di Austria, arciduchessa di Austria, figlia di Ferdinando I di Asburgo, imperatore del Sacro Romano Impero, e di Anna Jagellone.',
            'Maestro Ciliegia regala il pezzo di legno al suo amico Geppetto, il quale lo prende per fabbricarsi un burattino maraviglioso che sappia ballare, tirar di scherma e fare i salti mortali.',
            'Ho pensato di fabbricarmi da me un bel burattino di legno: ma un burattino maraviglioso, che sappia ballare, tirar di scherma e fare i salti mortali. Con questo burattino voglio girare il mondo, per buscarmi un tozzo di pane e un bicchier di vino.'
            );

        return [
            'title' => fake()->sentence(rand(1, 3)),
            'content' => $contenents[rand(0, sizeof($contenents) - 1)],
            //'publicationDate' => $date->format('Y-m-d'),//Carbon::now()->toDateString(),
            'image_path' => 'uploads/news/defaultNews_' . rand(0,9) . '.webp'
        ];
    }
}
