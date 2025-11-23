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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
           // TODO: id utente
            $table->string("titolo");
            $table->string("descrizione");
            $table->string("dataInizio");
            $table->string("dataFine");
            $table->string("luogo");
            // utente che ha generato l'evento
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->onDelete('set null'); 
            // NOTA: deve essere obbligatorio specificare il owner_user_id sia da isnerire durante la creazione delle'vento, ma se 
            // l'utente owner viene elimianto l'evento deve poter rimanere, per questo ho inserito "nullable()"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
