<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // verifico che gli utenti esistano, altrimenti li creo
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory(5)->withPersonalTeam()->create();
        }

        // prendo un user di default
        $defaultUser = User::find(1);

        // creo gli eventi
        $newEvents = Event::factory(5)->create();

        // collego gli id degli eventi all'user di default
        $defaultUser->events_to_do()->attach($newEvents->pluck('id'));

    }
}
