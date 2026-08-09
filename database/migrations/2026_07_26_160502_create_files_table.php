<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // Crea in automatico 2 colonne:
            // 1. fileable_type (VARCHAR) -> es. 'App\Models\Event' o 'App\Models\Article'
            // 2. fileable_id (BIGINT) -> es. 1, 2, 3...
            // e un indice combinato per velocizzare le query.
            $table->morphs('fileable');

            $table->string('file_name');
            $table->string('file_path');

            $table->string('mime_type')->nullable(); // es. 'application/pdf'
            $table->unsignedBigInteger('file_size')->nullable(); // dimensione in byte
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
