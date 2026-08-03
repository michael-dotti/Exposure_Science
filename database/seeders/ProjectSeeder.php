<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ResearchArea;

class ProjectSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$areas = ResearchArea::all();

		for($i = 0; $i < 10; $i++) {
			Project::factory(1)->hasAttached($areas->random(rand(1, 4)))->create();
		}
	}
}
