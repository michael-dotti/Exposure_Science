<?php

namespace Database\Factories;

use App\Models\EventAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

/**
 * @extends Factory<EventAttachment>
 */
class EventAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estensioni = ['pdf', 'docx', 'xlsx', 'png', 'zip'];
        $estensioneCasuale = fake()->randomElement($estensioni);
    
        $nomeFile = fake()->word() . '.' . $estensioneCasuale;

        return [
            'file_name' => $nomeFile,
            'file_path' => 'uploads/events/attachments/default_piano_di_studi_triennale_Ingegneria.pdf',
            'event_id' => Event::factory()
        ];
    }
}
