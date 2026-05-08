<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ResearchArea;
use Illuminate\Database\Seeder\ResearchAreaSeeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = ResearchArea::all();
        $defaultUser = User::all();
        for($x = 0; $x < 10; $x++) {
            Article::factory(1)->hasAttached($defaultUser[0])->hasAttached($areas->random(rand(1, 4)))->create();
        }

        for($x = 0; $x < 10; $x++) {
            Article::factory(1)->hasAttached($defaultUser[1])->hasAttached($areas->random(rand(1, 4)))->create();
        }
    }
}
