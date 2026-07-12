<?php

namespace Database\Seeders;

use Database\Factories\CourseFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // verifico che gli utenti esistano, altrimenti li creo
        $users = User::all();
        if ($users->count() < 3) {
            $newUsers = User::factory(5)->withPersonalTeam()->create();
            $users = $users->merge($newUsers); // Unisce i vecchi utenti con i nuovi 
        }

        // assegno a 2 user di default un corso + un corso in cui sono docenti entrambi
        $user1 = $users->first();
        $user2 = $users->get(2);

        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();
        
        $user1->courses()->attach($course1->id);
        $course1->teachers()->attach($user1->id);

        $user2->courses()->attach($course2->id);
        $course2->teachers()->attach($user2->id);

        $user1->courses()->attach($course3->id);
        $user2->courses()->attach($course3->id);
        $course3->teachers()->attach([
            $user1->id,
            $user2->id
        ]);
    }
}
