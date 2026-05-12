<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResearchArea;
use App\Enums\ResearchAreaType;

class ResearchAreaSeeder extends Seeder
{
    public function run(): void
    {
        $cases = ResearchAreaType::cases();

        ResearchArea::factory()
            ->count(count($cases))
            ->sequence(fn ($sequence) => ['name' => $cases[$sequence->index]])
            ->create();
    }
}
