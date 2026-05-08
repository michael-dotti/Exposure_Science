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
        Article::factory(10)->hasAttached($defaultUser[0])->hasAttached($areas->random(rand(1, 3)))->create();
        Article::factory(10)->hasAttached($defaultUser[1])->hasAttached($areas->random(rand(1, 3)))->create();
    }
}
