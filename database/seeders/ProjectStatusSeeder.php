<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectStatus;
use App\Enums\ProjectStatusType;

class ProjectStatusSeeder extends Seeder
{
	
	
	/**
	* Run the database seeds.
	*/
	public function run(): void
	{
		$cases = ProjectStatusType::cases();

		ProjectStatus::factory()
			->count(count($cases))
			->sequence(fn ($sequence) => ['name' => $cases[$sequence->index]])
			->create();
	}
}
