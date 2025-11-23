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
        Schema::create('article_user', function (Blueprint $table) {
            $table->id();
            
            // Colonna per la chiave esterna di 'articles'
            $table->foreignId('article_id')->constrained()->onDelete('cascade'); 
            // Colonna per la chiave esterna di 'users'
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Aggiungere un indice unico per prevenire duplicati
            $table->unique(['article_id', 'user_id']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_user');
    }
};
