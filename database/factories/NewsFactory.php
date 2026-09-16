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
            'Gabbiano ferito recuperato alla foce del Vagliolo: affidato alle cure del centro specializzato "Povero Gabbiano srl"',
            'Cesare Borgia, detto il Valentino, è stato un generale, cardinale e politico italiano di origini valenciane. Figlio illegittimo del papa Alessandro VI, fu il maggiore tra i suoi fratelli e fu un uomo politico spregiudicato, determinato e pronto a tutto per il potere; fu certamente una delle figure più controverse del Rinascimento italiano.',
            'È curioso a vedere, che gli uomini di molto merito hanno sempre le maniere semplici, e che sempre le maniere semplici sono prese per indizio di poco merito.',
            'Maria dei Medici era la sesta figlia di Francesco I dei Medici, granduca di Toscana, e di Giovanna di Austria, arciduchessa di Austria, figlia di Ferdinando I di Asburgo, imperatore del Sacro Romano Impero, e di Anna Jagellone.',
            'Maestro Ciliegia regala il pezzo di legno al suo amico Geppetto, il quale lo prende per fabbricarsi un burattino maraviglioso che sappia ballare, tirar di scherma e fare i salti mortali.',
            'Ho pensato di fabbricarmi da me un bel burattino di legno: ma un burattino maraviglioso, che sappia ballare, tirar di scherma e fare i salti mortali. Con questo burattino voglio girare il mondo, per buscarmi un tozzo di pane e un bicchier di vino.'
            );

        return [
            'title' => fake()->sentence(rand(1, 3)),
            'content' => $contenents[rand(0, sizeof($contenents) - 1)],
            //'publicationDate' => $date->format('Y-m-d'),//Carbon::now()->toDateString(),
            'image_path' => 'uploads/news/defaultNews_' . rand(0,6) . '.webp'
        ];
    }
}
