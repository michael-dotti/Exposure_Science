<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
        $defaultUser = User::all();

		for($i = 0; $i < 10; $i++) {
			Project::factory(1)->hasAttached($defaultUser[random_int(0,sizeof($defaultUser)-1)])->create();
		}
	}
}
