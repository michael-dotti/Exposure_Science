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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("titolo");
            $table->string("descrizione");
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            /*
            Spiegazione dei metodi:
    $table->foreignId('user_id'): creare una colonna user_id di tipo UNSIGNED BIGINT (il tipo predefinito per gli ID).
    ->nullable(): Permette che un corso non abbia un user_id associato.
    ->constrained('users'): Indica che questa colonna è una chiave esterna che fa riferimento alla colonna id
                             della tabella users.
    ->onDelete('set null'): Se l'utente insegnante viene eliminato dal database,
                         il campo user_id nei corsi che insegnava verrà automaticamente impostato a NULL   
                         , mantenendo i dati del corso.
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
