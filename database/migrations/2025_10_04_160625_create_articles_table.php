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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('data_pubblicazione');
            //TODO : autori... 
            $table->string('abstract')->nullable();
            $table->timestamps();
            //TODO possibilità di inserire dall'esterno un file contenente l'articolo oppure un link al sito dove acquistare l'articolo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
