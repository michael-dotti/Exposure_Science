<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        $estensioni = ['pdf', 'docx', 'xlsx', 'png', 'zip'];
        $estensioneCasuale = fake()->randomElement($estensioni);
    
        $nomeFile = fake()->word() . '.' . $estensioneCasuale;
        return [
            'file_name' => $nomeFile,
            'file_path' => 'uploads/events/attachments/default_piano_di_studi_triennale_Ingegneria.pdf',
            'mime_type' => fake()->mimeType(),          // Genera un mime_type valido (es. 'application/pdf')
            'file_size' => fake()->numberBetween(50000, 5000000),    // Dimensione simulata in byte (tra ~50KB e 5MB)
        ];
    }
}
